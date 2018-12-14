<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use IonutMilica\LaravelSettings\SettingsContract;
use Smile\Core\Services\UserService;

class AccountController extends BaseSiteController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @param UserService $userService
     * @param SettingsContract $settings
     */
    public function __construct(UserService $userService, SettingsContract $settings)
    {
        $this->middleware('auth');

        $this->userService = $userService;
        $this->settings = $settings;
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

        $success = $this->userService->delete($request->user(), $request->all());

        if (!$success) {
            return new JsonResponse(['password' => __('Invalid password for your current account!')], 401);
        }

        return [];
    }

    /**
     * Display settings form
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showSettings(Request $request)
    {
        $user = $request->user();

        return $this->view('account.settings', compact('user'));
    }

    /**
     * Reset avatar to default
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetAvatar(Request $request)
    {
        $this->userService->resetAvatar($request->user());

        return redirect()->back();
    }

    /**
     * Store saved settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSettings(Request $request)
    {
        $this->validate($request, $this->validationRulesForSettings($request));

        $fields = $request->only(['name', 'email', 'password', 'avatar', 'language', 'nsfw']);

        if (perm('demo')) {
            unset($fields['password'], $fields['language'], $fields['name'], $fields['email']);
        }

        $this->userService->updateProfile($request->user(), $fields);

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
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'name' => 'required|min:3|max:15|unique:users,name,' . $request->user()->id,
            'avatar' => 'image|max:' . ((int)setting('avatar-size', 3072)),
            'language' => 'required|in:' . validateLangs(),
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
