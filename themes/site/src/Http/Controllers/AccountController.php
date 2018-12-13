<?php
namespace Themes\Site\Http\Controllers;

use IonutMilica\LaravelSettings\SettingsContract;
use Illuminate\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smile\Core\Services\UserService;

class AccountController extends BaseSiteController
{
    /**
     * Current logged in user
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    private $currentUser;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @param UserService $userService
     * @param Guard $auth
     * @param SettingsContract $settings
     */
    public function __construct(UserService $userService, Guard $auth, SettingsContract $settings)
    {
        $this->middleware('auth');

        $this->currentUser = $auth->user();
        $this->userService = $userService;
        $this->settings = $settings;
        $this->auth = $auth;
    }

    /**
     * Delete account
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
           'password' => 'required'
        ]);

        if (perm('demo')) {
            return [];
        }

        $success = $this->userService->delete($this->currentUser, $request->all());

        if ( ! $success) {
            return new JsonResponse(['password' => __('Invalid password for your current account!')], 401);
        }

        return [];
    }

    /**
     * Display settings form
     *
     * @param Guard $auth
     * @return \Illuminate\View\View
     */
    public function showSettings(Guard $auth)
    {
        $user = $auth->user();

        return $this->view('account.settings', compact('user'));
    }

    /**
     * Reset avatar to default
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetAvatar()
    {
        $this->userService->resetAvatar($this->currentUser);

        return redirect()->back();
    }

    /**
     * Store saved settings
     *
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSettings(Request $request, UserService $userService)
    {
        $this->validate($request, $this->validationRulesForSettings($request));

        $fields = $request->only(['name', 'email', 'password', 'avatar', 'language', 'nsfw']);

        if (perm('demo')) {
            unset($fields['password'], $fields['language'], $fields['name'], $fields['email']);
        }

        $userService->updateProfile($this->currentUser, $fields);

        return redirect()->back();
    }

    /**
     * Prepare validation rules for user settings form
     *
     * @param Request $request
     * @return array
     */
    protected function validationRulesForSettings(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email,'.$this->currentUser->id,
            'name'  => 'required|min:3|max:15|unique:users,name,'.$this->currentUser->id,
            'avatar' => 'image|max:'.((int)setting('avatar-size', 3072)),
            'language' => 'required|in:'.validateLangs(),
            'nsfw' => 'required|boolean',
        ];

        if ($request->has('password')) {
            $rules['password'] = 'required|min:6';
            $rules['password_confirmation'] = 'required|min:6|same:password';
        }

        if ($request->files->has('avatar')) {
            $rules['avatar'] = 'required|image';
        }

        return $rules;
    }

}
