<?php

namespace Smile\Http\Requests;

class ContactRequest extends Request
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
            'name' => 'required|min:3',
            'email' => 'required|email|max:255',
            'subject' => 'required|min:4',
            'text' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];

        hook('request.contact', $rules);

        if ( ! setting('captcha.secret')) {
            unset($rules['g-recaptcha-response']);
        }

        return $rules;
    }

}
