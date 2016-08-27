<?php
namespace App\Http\Controllers\Backend\Organization\Project;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Access\User\User;
use App\Repositories\Backend\Access\User\UserRepositoryContract;
use App\Repositories\Backend\Access\Role\RoleRepositoryContract;

/**
 * Class TeamController
 */
class ProjectController extends Controller
{
    /**
     * @var UserRepositoryContract
     */
    protected $users;

    /**
     * @var RoleRepositoryContract
     */
    protected $roles;

    /**
     * @param UserRepositoryContract $users
     * @param RoleRepositoryContract $roles
     */
    public function __construct(UserRepositoryContract $users, RoleRepositoryContract $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }
    
    // GET /project
    public function index(Request $request)
    {
        $projects = DB::select('select * from projects;');
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
        
        if ($request->ajax()){
            return response()->json($projects);
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
            
            $users = User::all();
    
            DB::delete('delete from projects where id = :id', ['id' => $project['id']]);
            DB::delete('delete m from members m inner join members2project m2p on m.id = m2p.member_id where m2p.project_id = :id', ['id' => $project['id']]);
            DB::delete('delete from members2project where project_id = :id', ['id' => $project['id']]);
            
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
                
                $exists = $users->filter(function($user) use($member) {
                    return $user->email == $member['id'];
                })->count() > 0;
                if ($exists){
                    // 随机密码
                    $password = str_random(6);
                    $this->users->create(
                        [
                            'name' => $member['nick_name'],
                            'email' => $member['email'],
                            'password' => $password,
                            'password_confirmation' => $password,
                            'status' => 1,
                            'confirmation_email' => 1
                        ],
                        [ 
                            'assignees_roles' => ['3']
                        ]
                    );
                }
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
