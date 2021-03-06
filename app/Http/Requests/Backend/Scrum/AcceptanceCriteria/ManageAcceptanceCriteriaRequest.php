<?php
namespace App\Http\Requests\Backend\Scrum\AcceptanceCriteria;

use App\Http\Requests\Request;

/**
 * Class ManageAcceptanceCriteriaRequest
 * 
 * @package App\Http\Requests\Backend\Scrum\AcceptanceCriteria
 */
class ManageAcceptanceCriteriaRequest extends Request
{

    /**
     * Determine if the acceptancecriteria is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-acceptancecriterias');
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
