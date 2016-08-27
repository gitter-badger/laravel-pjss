<?php

namespace App\Http\Controllers\Backend\Scrum\BacklogMeeting;

use App\Models\Scrum\BacklogMeeting\BacklogMeeting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Scrum\BacklogMeeting\StoreBacklogMeetingRequest;
use App\Http\Requests\Backend\Scrum\BacklogMeeting\ManageBacklogMeetingRequest;
use App\Http\Requests\Backend\Scrum\BacklogMeeting\UpdateBacklogMeetingRequest;
use App\Repositories\Backend\Scrum\BacklogMeeting\BacklogMeetingRepositoryContract;

/**
 * Class BacklogMeetingController
 */
class BacklogMeetingController extends Controller
{
    /**
     * @var BacklogMeetingRepositoryContract
     */
    protected $backlogmeetings;
    
    /**
     * @param BacklogMeetingRepositoryContract $backlogmeetings
     */
    public function __construct(BacklogMeetingRepositoryContract $backlogmeetings)
    {
        $this->backlogmeetings = $backlogmeetings;
    }

	/**
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function index(ManageBacklogMeetingRequest $request)
    {
    	$backlog_meetings = BacklogMeeting::all();
    	
    	if ($request->ajax()){
            return response()->json(backlog_meetings);
        }
    
        return view('backend.scrum.backlogmeeting.index')
        	->withBacklogMeetings($backlog_meetings);
    }

	/**
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function create(ManageBacklogMeetingRequest $request)
    {
        return view('backend.scrum.backlogmeeting.create');
    }

	/**
     * @param StoreBacklogMeetingRequest $request
     * @return mixed
     */
    public function store(StoreBacklogMeetingRequest $request)
    {
        $this->backlogmeetings->create(
            $request->all()
        );
        return redirect()->route('admin.scrum.backlogmeeting.index')->withFlashSuccess(trans('alerts.backend.scrum.backlogmeetings.created'));
    }
    
    /**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function show(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        return view('backend.scrum.backlogmeeting.detail')
        	->withBacklogMeeting($backlogmeeting);
    }

	/**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function edit(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        return view('backend.scrum.backlogmeeting.edit')
            ->withBacklogMeeting($backlogmeeting);
    }

	/**
     * @param BacklogMeeting $backlogmeeting
     * @param UpdateBacklogMeetingRequest $request
     * @return mixed
     */
    public function update(BacklogMeeting $backlogmeeting, UpdateBacklogMeetingRequest $request)
    {
        $this->backlogmeetings->update($backlogmeeting,
            $request->all()
        );
        return redirect()->route('admin.scrum.backlogmeeting.index')->withFlashSuccess(trans('alerts.backend.scrum.backlogmeetings.updated'));
    }

	/**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function destroy(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        $this->backlogmeetings->destroy($backlogmeeting);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.scrum.backlogmeetings.deleted'));
    }
}