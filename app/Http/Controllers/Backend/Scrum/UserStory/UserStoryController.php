<?php

namespace App\Http\Controllers\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Scrum\UserStory\StoreUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\ManageUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\UpdateUserStoryRequest;
use App\Repositories\Backend\Scrum\UserStory\UserStoryRepositoryContract;
use App\Http\Requests\Backend\Scrum\UserStory\Excel\UserStroyImport;
use DB;

/**
 * Class UserStoryController
 */
class UserStoryController extends Controller
{
    /**
     * @var UserStoryRepositoryContract
     */
    protected $userstories;
    
    /**
     * @param UserStoryRepositoryContract $userstories
     */
    public function __construct(UserStoryRepositoryContract $userstories)
    {
        $this->userstories = $userstories;
    }

	/**
     * @param ManageUserStoryRequest $request
     * @return mixed
     */
    public function index(ManageUserStoryRequest $request)
    {
        if (is_null(session('project_id'))) {
            $project_id = DB::select('select m2p.project_id from members2project m2p inner join members m on m.id = m2p.member_id where m.email = :email', [
                'email' => \Auth::user()->email
            ]);
            $request->session()->put('project_id', $project_id[0]->project_id);
        }

    	$user_stories = UserStory::all()->where('project_id', session('project_id'))->sortByDesc('priority');
    	
    	if ($request->ajax()){
            return response()->json($user_stories->toArray());
        }
    
        return view('backend.scrum.userstory.index')
        	->withUserStories($user_stories->toJson());
    }

	/**
     * @param ManageUserStoryRequest $request
     * @return mixed
     */
    public function create(ManageUserStoryRequest $request)
    {
        return view('backend.scrum.userstory.create');
    }

	/**
     * @param StoreUserStoryRequest $request
     * @return mixed
     */
    public function store(StoreUserStoryRequest $request)
    {
        $this->userstories->create(
            $request
        );
        return redirect()->route('admin.scrum.userstory.index')->withFlashSuccess(trans('alerts.backend.scrum.userstories.created'));
    }
    
    /**
     * @param UserStory $userstory
     * @param ManageUserStoryRequest $request
     * @return mixed
     */
    public function show(UserStory $userstory, ManageUserStoryRequest $request)
    {
        return view('backend.scrum.userstory.detail')
        	->withUserStory($userstory);
    }

	/**
     * @param UserStory $userstory
     * @param ManageUserStoryRequest $request
     * @return mixed
     */
    public function edit(UserStory $userstory, ManageUserStoryRequest $request)
    {
        return view('backend.scrum.userstory.edit')
            ->withUserStory($userstory);
    }

	/**
     * @param UserStory $userstory
     * @param UpdateUserStoryRequest $request
     * @return mixed
     */
    public function update(UserStory $userstory, UpdateUserStoryRequest $request)
    {
        $this->userstories->update($userstory,
            $request
        );
        return redirect()->route('admin.scrum.userstory.index')->withFlashSuccess(trans('alerts.backend.scrum.userstories.updated'));
    }

	/**
     * @param UserStory $userstory
     * @param ManageUserStoryRequest $request
     * @return mixed
     */
    public function destroy(UserStory $userstory, ManageUserStoryRequest $request)
    {
        $this->userstories->destroy($userstory);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.scrum.userstories.deleted'));
    }
    
    public function importExcel(UserStroyImport $import) {
        // get the results
        $results = $import->toArray();
        $this->userstories->importExcel($results[0]);
        
        return response()->json($results);
    }
}