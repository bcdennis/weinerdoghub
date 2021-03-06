<?php

namespace Smile\Http\Requests;

class CreateFileUploadRequest extends Request
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
            'media' => 'required|image|max:' . ((int)setting('image-size', 3072)),
            'title' => 'required|between:3,' . setting('post-size', 100),
            'categories' => 'required|between:1,' . setting('maximum-categories', 2),
        ];

        foreach ($this->get('categories', []) as $category) {
            $rules['categories.' . $category] = 'required|exists:categories,slug';
        }

        hook('request.file-upload', $rules);

        return $rules;
    }
}
