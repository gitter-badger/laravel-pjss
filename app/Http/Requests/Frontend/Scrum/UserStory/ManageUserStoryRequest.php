<?php
namespace App\Http\Requests\Frontend\Scrum\UserStory;

use App\Http\Requests\Request;

/**
 * Class ManageUserStoryRequest
 * 
 * @package App\Http\Requests\Frontend\Scrum\UserStory
 */
class ManageUserStoryRequest extends Request
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
        return []
        //
        ;
    }
}
