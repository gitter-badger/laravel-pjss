<?php
namespace App\Http\Requests\Frontend\File\Media;

use App\Http\Requests\Request;

/**
 * Class ManageMediaRequest
 * 
 * @package App\Http\Requests\Frontend\File\Media
 */
class ManageMediaRequest extends Request
{

    /**
     * Determine if the media is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-media');
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
