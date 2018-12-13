<?php

namespace Smile\Core\Services;

use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteManager;
use Smile\Core\Contracts\Image\UploaderContract;
use Smile\Events\User\UserCreatedThroughOAuth;
use Smile\Core\Persistence\Repositories\OAuthIdentityContract;
use Smile\Core\Persistence\Repositories\UserContract;

class OAuth
{
    /**
     * @var SocialiteManager
     */
    private $social;
    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var UserContract
     */
    private $user;
    /**
     * @var OauthIdentityContract
     */
    private $oauth;
    /**
     * @var UploaderContract
     */
    private $image;

    /**
     *
     * @param Factory $social
     * @param Guard $auth
     * @param UserContract $user
     * @param OAuthIdentityContract $oauth
     * @param UploaderContract $image
     */
    public function __construct(Factory $social, Guard $auth,
                                UserContract $user,
                                OAuthIdentityContract $oauth,
                                UploaderContract $image)
    {
        $this->social = $social;
        $this->auth = $auth;
        $this->user = $user;
        $this->oauth = $oauth;
        $this->image = $image;
    }

    /**
     * Redirect to OAuth provider
     *
     * @param $provider
     * @return bool
     */
    public function redirectToProvider($provider)
    {
        return $this->social->with($provider)->redirect();
    }

    /**
     * Autneticat
     *
     * @param $provider
     * @return bool
     */
    public function authenticate($provider)
    {
        $socialUser = $this->social->with($provider)->stateless()->user();

        if ( ! $socialUser) {
            return false;
        }

        $identity = $this->oauth->findByProviderNameAndId($socialUser->id, $provider);

        if ($identity) {
            $this->oauth->update($identity, ['token' => $socialUser->token]);
            $this->auth->loginUsingId($identity->user_id, true);
            return true;
        }

        $user = $this->user->findByEmail($socialUser->email);

        // User exists, we just attach provider info to it
        if ( ! is_null($user)) {
            $this->oauth->create([
                'provider_id' => $socialUser->id,
                'provider' => $provider,
                'user_id' => $user->id,
                'token' => $socialUser->token
            ]);

            $this->user->update($user, ['status' => 1]);
            if ( ! $this->user->block) {
                $this->auth->login($user, true);
                return true;
            }
            return false;
        }

        // User creation

        if ( ! setting('registration', true)) {
            return false;
        }

        // Just create the user
        $newUser = $this->user->create([
            'name' => $this->emailToName($socialUser->email),
            'email' => $socialUser->email,
            'password' => '',
            'status' => 1,
            'avatar'  => $socialUser->avatar,
        ]);

        event(new UserCreatedThroughOAuth($newUser));

        $this->oauth->create([
            'provider_id' => $socialUser->id,
            'provider' => $provider,
            'user_id' => $newUser->id,
            'token' => $socialUser->token
        ]);

        $this->auth->login($newUser, true);

        return true;
    }

    /**
     * Generate a unique name from an email address
     *
     * @param $email
     * @return mixed|string
     */
    function emailToName($email)
    {
        $email = mb_split('@', $email)[0];
        $name = preg_replace('/[^A-Za-z0-9]/', '', $email);

        do {
            if ( ! $this->user->findByName($name)) break;
            $nameRev = mb_strrev($name);

            $number = 1;

            if (preg_match('/([0-9]+)(.+)/us', $nameRev, $out)) {
                $name = mb_strrev($out[2]);
                $number = $out[1] + 1;
            }

            $name = $name.$number;
        } while(1);

        return $name;
    }
}