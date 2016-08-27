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
        $teams = [];
        
        if ($request->ajax()) {
            return response()->json($teams);
        }
        
        return view('backend.team.index', [
            'teams' => json_encode($teams, 0, 10)
        ]);
    }
}
