<?php

namespace App\Http\Controllers\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Scrum\UserStory\StoreUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\ManageUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\UpdateUserStoryRequest;
use App\Repositories\Backend\Scrum\UserStory\UserStoryRepositoryContract;

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
    	$user_stories = UserStory::all();
    	
    	if ($request->ajax()){
            return response()->json(user_stories);
        }
    
        return view('backend.scrum.userstory.index')
        	->withUserStories($user_stories);
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
}