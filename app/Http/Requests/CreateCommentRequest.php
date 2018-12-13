<?php

namespace Smile\Http\Requests;

class CreateCommentRequest extends Request
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
			'message' => 'required|min:1',
		];

		if ($this->has('parent_id')) {
			$rules['parent_id'] = 'required|exists:comments,id';
		}

		hook('request.create-comment', $rules);

		return $rules;
	}
}