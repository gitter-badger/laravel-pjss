<?php
namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class UserStoryController
 */
class SSOController extends Controller
{

    /**
     */
    public function __construct()
    {}

    /**
     * 畅言-获取用户信息接口
     *
     * @return mixed
     */
    public function changyan(Request $request)
    {
        return response()->jsonp($request->get('callback'), [
            'is_login' => 1,
            'user' => array(
                'user_id' => access()->user()->id,
                'nickname' => access()->user()->name,
                'img_url' => access()->user()->picture,
                'profile_url' => access()->user()->picture,
                'sign' => '*'
            )
        ]);
    }
}