<?php

namespace App\Repositories\Backend\Scrum\Meeting;

use App\Models\Scrum\Meeting\Meeting;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Scrum\Meeting\MeetingCreated;
use App\Events\Backend\Scrum\Meeting\MeetingUpdated;
use App\Events\Backend\Scrum\Meeting\MeetingDeleted;
use App\Events\Backend\Scrum\Meeting\MeetingRestored;

/**
 * Class EloquentMeetingRepository
 * @package App\Repositories\Meeting
 */
class EloquentMeetingRepository implements MeetingRepositoryContract
{
    /**
     */
    public function __construct()
    {
        
    }

    /**
     * @param  $input
     * @param  $roles
     * @throws GeneralException
     * @return bool
     */
    public function create($input)
    {
        $meeting = $this->createMeetingStub($input);
        //TODO: set properties

		DB::transaction(function() use ($meeting) {
			if ($meeting->save()) {
				event(new MeetingCreated($meeting));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.meetings.create_error'));
		});
    }

    /**
     * @param Meeting $meeting
     * @param $input
     * @param $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(Meeting $meeting, $input)
    {
    	//TODO: set $input properties
    	
		DB::transaction(function() use ($meeting, $input) {
			if ($meeting->update($input)) {
				event(new MeetingUpdated($meeting));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.meetings.update_error'));
		});
    }
    /**
     * @param  Meeting $meeting
     * @throws GeneralException
     * @return bool
     */
    public function destroy(Meeting $meeting)
    {
        if ($meeting->delete()) {
            event(new MeetingDeleted($meeting));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.meetings.delete_error'));
    }

    /**
     * @param  Meeting $meeting
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(Meeting $meeting)
    {
        //Failsafe
        if (is_null($meeting->deleted_at)) {
            throw new GeneralException("This meeting must be deleted first before it can be destroyed permanently.");
        }

		DB::transaction(function() use ($meeting) {
			//TODO: delete related entities

			if ($meeting->forceDelete()) {
				event(new MeetingPermanentlyDeleted($meeting));
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.scrum.meetings.delete_error'));
		});
    }

    /**
     * @param  Meeting $meeting
     * @throws GeneralException
     * @return bool
     */
    public function restore(Meeting $meeting)
    {
        //Failsafe
        if (is_null($meeting->deleted_at)) {
            throw new GeneralException("This meeting is not deleted so it can not be restored.");
        }

        if ($meeting->restore()) {
            event(new MeetingRestored($meeting));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.meetings.restore_error'));
    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createMeetingStub($input)
    {
        $meeting                    = new Meeting;
        //TODO: set properties

        return $meeting;
    }
}
