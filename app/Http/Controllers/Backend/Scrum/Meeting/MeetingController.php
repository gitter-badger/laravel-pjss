<?php

namespace App\Http\Controllers\Backend\Scrum\Meeting;

use App\Models\Scrum\Meeting\Meeting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Scrum\Meeting\StoreMeetingRequest;
use App\Http\Requests\Backend\Scrum\Meeting\ManageMeetingRequest;
use App\Http\Requests\Backend\Scrum\Meeting\UpdateMeetingRequest;
use App\Repositories\Backend\Scrum\Meeting\MeetingRepositoryContract;

/**
 * Class MeetingController
 */
class MeetingController extends Controller
{
    /**
     * @var MeetingRepositoryContract
     */
    protected $meetings;
    
    /**
     * @param MeetingRepositoryContract $meetings
     */
    public function __construct(MeetingRepositoryContract $meetings)
    {
        $this->meetings = $meetings;
    }

	/**
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function index(ManageMeetingRequest $request)
    {
    	$meetings = Meeting::all();
    	
    	if ($request->ajax()){
            return response()->json(meetings);
        }
    
        return view('backend.scrum.meeting.index')
        	->withMeetings($meetings);
    }

	/**
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function create(ManageMeetingRequest $request)
    {
        return view('backend.scrum.meeting.create');
    }

	/**
     * @param StoreMeetingRequest $request
     * @return mixed
     */
    public function store(StoreMeetingRequest $request)
    {
        $this->meetings->create(
            $request->all()
        );
        return redirect()->route('admin.scrum.meeting.index')->withFlashSuccess(trans('alerts.backend.scrum.meetings.created'));
    }
    
    /**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function show(Meeting $meeting, ManageMeetingRequest $request)
    {
        return view('backend.scrum.meeting.detail')
        	->withMeeting($meeting);
    }

	/**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function edit(Meeting $meeting, ManageMeetingRequest $request)
    {
        return view('backend.scrum.meeting.edit')
            ->withMeeting($meeting);
    }

	/**
     * @param Meeting $meeting
     * @param UpdateMeetingRequest $request
     * @return mixed
     */
    public function update(Meeting $meeting, UpdateMeetingRequest $request)
    {
        $this->meetings->update($meeting,
            $request->all()
        );
        return redirect()->route('admin.scrum.meeting.index')->withFlashSuccess(trans('alerts.backend.scrum.meetings.updated'));
    }

	/**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function destroy(Meeting $meeting, ManageMeetingRequest $request)
    {
        $this->meetings->destroy($meeting);
        return redirect()->back()->withFlashSuccess(trans('alerts.backend.scrum.meetings.deleted'));
    }
}