<?php
namespace App\Http\Controllers\Backend\Organization\Project;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_encode;

/**
 * Class TeamController
 */
class ProjectController extends Controller
{

    /**
     *
     * @param UserRepositoryContract $users            
     * @param RoleRepositoryContract $roles            
     */
    public function __construct()
    {
        // $this->middleware('auth');
        
        // $this->middleware('log', []);
    }
    
    // GET /project
    public function index(Request $request)
    {
        $projects = DB::select('select * from projects limit 10;');
        $members = DB::select('select * from members;');
        $members2projects = DB::select('select * from members2project;');
        foreach ($projects as $project) {
            $tmp_members = [];
            foreach ($members2projects as $members2project) {
                if ($project->id == $members2project->project_id) {
                    foreach ($members as $member) {
                        if ($member->id == $members2project->member_id) {
                            array_push($tmp_members, $member);
                        }
                    }
                }
            }
            $project->members = $tmp_members;
        }
        
        return view('backend.project.index', [
            'projects' => json_encode($projects, 0, 10)
        ]);
    }
    
    // GET /project/create
    public function create(Request $request)
    {
        return 'create';
    }
    
    // POST /project
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $project = $input['project'];
            $members = $input['members'];
    
            $project['create_date'] = date('y-m-d h:i:s',time());
            DB::insert('insert into projects (id, name, create_date) values (?, ?, ?)', [
                $project['id'], $project['name'], $project['create_date']
            ]);
            foreach ($members as $member) {
                DB::insert('insert into members2project (member_id, project_id) values (?, ?)', [
                    $member['id'], $project['id']
                ]);
                DB::insert('insert into members (id, email, head_img_letter, head_img_name, head_img_path, head_img_status, is_admin, nick_name) values (?, ?, ?, ?, ?, ?, ?, ?)', [
                    $member['id'], $member['email'], $member['head_img_letter'], $member['head_img_name'], $member['head_img_path'], $member['head_img_status'], $member['is_admin'], $member['nick_name']
                ]);
            }
    
            return response()->json([
                'reuslt' => 'success'
            ]);
        }catch (Exception $e) {
            return response()->json([
                'reuslt' => 'fail',
                'message' => $e->message
            ]);
        }
    }
    
    // GET /project/{project}
    public function show(Request $request)
    {
        return 'show';
    }
    
    // GET /project/{project}/edit
    public function edit(Request $request)
    {
        return 'edit';
    }
    
    // PUT/PATCH /project/{project}
    public function update(Request $request)
    {
        return 'update';
    }
    
    // DELETE /project/{project}
    public function destroy(Request $request)
    {
        return 'destroy';
    }
}
