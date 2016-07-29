<?php
namespace App\Http\Controllers\Backend\Organization\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class TeamController
 */
class TeamController extends Controller
{

    /**
     *
     * @param UserRepositoryContract $users            
     * @param RoleRepositoryContract $roles            
     */
    public function __construct()
    {}

    /**
     *
     * @param ManageUserRequest $request            
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('backend.team.index');
    }
}
