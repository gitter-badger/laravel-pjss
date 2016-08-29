<?php

namespace App\Http\Controllers\Frontend\Scrum\Meeting;

use App\Models\Scrum\Meeting\Meeting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Scrum\Meeting\StoreMeetingRequest;
use App\Http\Requests\Frontend\Scrum\Meeting\ManageMeetingRequest;
use App\Http\Requests\Frontend\Scrum\Meeting\UpdateMeetingRequest;
use App\Repositories\Frontend\Scrum\Meeting\MeetingRepositoryContract;

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
    	if ($request->ajax()){
            return response()->json($this->meetings);
        }
    
        return view('frontend.scrum.meeting.index')
        	->withMeetings($this->meetings);
    }

	/**
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function create(ManageMeetingRequest $request)
    {
        return view('frontend.scrum.meeting.create');
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
        return redirect()->route('scrum.meeting.index')->withFlashSuccess(trans('alerts.frontend.scrum.meetings.created'));
    }
    
    /**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function show(Meeting $meeting, ManageMeetingRequest $request)
    {
        return view('frontend.scrum.meeting.detail')
        	->withMeeting($meeting);
    }

	/**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function edit(Meeting $meeting, ManageMeetingRequest $request)
    {
        return view('frontend.scrum.meeting.edit')
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
        return redirect()->route('scrum.meeting.index')->withFlashSuccess(trans('alerts.frontend.scrum.meetings.updated'));
    }

	/**
     * @param Meeting $meeting
     * @param ManageMeetingRequest $request
     * @return mixed
     */
    public function destroy(Meeting $meeting, ManageMeetingRequest $request)
    {
        $this->meetings->destroy($meeting);
        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.scrum.meetings.deleted'));
    }
}