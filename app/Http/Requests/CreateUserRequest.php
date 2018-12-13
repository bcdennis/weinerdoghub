<?php

namespace Smile\Http\Requests;

class CreateUserRequest extends Request
{

    /**
     * Authorize access to this action
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get rules for this request
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:users|min:3|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|captcha'
        ];

        if ( ! setting('captcha.secret')) {
            unset($rules['g-recaptcha-response']);
        }

        hook('request.create-user', $rules);

        return $rules;
    }
}