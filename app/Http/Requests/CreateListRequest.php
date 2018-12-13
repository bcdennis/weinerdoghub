<?php

namespace Smile\Http\Requests;

class CreateListRequest extends Request
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
            'media' => 'required|image|max:'.((int)setting('image-size', 3072)),
            'title' => 'required|between:3,'.setting('post-size', 100),
            'items' => 'required',
            'categories' => 'required|between:1,'.setting('maximum-categories', 2),
        ];

        foreach ($this->get('categories', []) as $category) {
            $rules['categories.'.$category] = 'required|exists:categories,slug';
        }

        $items = $this->all()['items'];

        foreach ($items as $pos => $item) {
            if (isset($item['media'])) {
                $rules['items.'.$pos.'.media'] = 'required|image';
            } else {
                $rules['items.'.$pos.'.link'] = 'required';
            }
            $rules['items.'.$pos.'.title'] = 'required';
        }

        hook('request.create-list', $rules);

        return $rules;
    }
}
