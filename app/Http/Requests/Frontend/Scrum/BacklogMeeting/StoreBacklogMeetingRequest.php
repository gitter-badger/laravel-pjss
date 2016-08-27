<?php

namespace App\Http\Requests\Frontend\Scrum\BacklogMeeting;

use App\Http\Requests\Request;

/**
 * Class StoreBacklogMeetingRequest
 * @package App\Http\Requests\Frontend\Scrum\BacklogMeeting
 */
class StoreBacklogMeetingRequest extends Request
{
	/**
	 * Determine if the backlogmeeting is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->allow('manage-backlogmeetings');
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
