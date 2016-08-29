<?php

namespace App\Http\Requests\Frontend\Scrum\Meeting;

use App\Http\Requests\Request;

/**
 * Class UpdateMeetingRequest
 * @package App\Http\Requests\Frontend\Scrum\Meeting
 */
class UpdateMeetingRequest extends Request
{
	/**
	 * Determine if the meeting is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->allow('manage-meetings');
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
