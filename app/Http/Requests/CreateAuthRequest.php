<?php

namespace Smile\Http\Requests;

class CreateAuthRequest extends Request
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
            'email' => 'required|email',
            'password' => 'required'
        ];

        hook('request.auth', $rules);

        return $rules;
    }

}
