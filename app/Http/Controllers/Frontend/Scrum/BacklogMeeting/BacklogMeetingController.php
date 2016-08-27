<?php

namespace App\Http\Controllers\Frontend\Scrum\BacklogMeeting;

use App\Models\Scrum\BacklogMeeting\BacklogMeeting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Scrum\BacklogMeeting\StoreBacklogMeetingRequest;
use App\Http\Requests\Frontend\Scrum\BacklogMeeting\ManageBacklogMeetingRequest;
use App\Http\Requests\Frontend\Scrum\BacklogMeeting\UpdateBacklogMeetingRequest;
use App\Repositories\Frontend\Scrum\BacklogMeeting\BacklogMeetingRepositoryContract;

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
    	if ($request->ajax()){
            return response()->json($this->backlogmeetings);
        }
    
        return view('frontend.scrum.backlogmeeting.index')
        	->withBacklogMeetings($this->backlogmeetings);
    }

	/**
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function create(ManageBacklogMeetingRequest $request)
    {
        return view('frontend.scrum.backlogmeeting.create');
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
        return redirect()->route('scrum.backlogmeeting.index')->withFlashSuccess(trans('alerts.frontend.scrum.backlogmeetings.created'));
    }
    
    /**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function show(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        return view('frontend.scrum.backlogmeeting.detail')
        	->withBacklogMeeting($backlogmeeting);
    }

	/**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function edit(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        return view('frontend.scrum.backlogmeeting.edit')
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
        return redirect()->route('scrum.backlogmeeting.index')->withFlashSuccess(trans('alerts.frontend.scrum.backlogmeetings.updated'));
    }

	/**
     * @param BacklogMeeting $backlogmeeting
     * @param ManageBacklogMeetingRequest $request
     * @return mixed
     */
    public function destroy(BacklogMeeting $backlogmeeting, ManageBacklogMeetingRequest $request)
    {
        $this->backlogmeetings->destroy($backlogmeeting);
        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.scrum.backlogmeetings.deleted'));
    }
}