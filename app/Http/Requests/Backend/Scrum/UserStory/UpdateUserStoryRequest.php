<?php

namespace App\Http\Requests\Backend\Scrum\UserStory;

use App\Http\Requests\Request;

/**
 * Class UpdateUserStoryRequest
 * @package App\Http\Requests\Backend\Scrum\UserStory
 */
class UpdateUserStoryRequest extends Request
{
	/**
	 * Determine if the userstory is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->allow('manage-userstories');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}
}
