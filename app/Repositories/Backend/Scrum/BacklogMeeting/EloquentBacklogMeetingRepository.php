<?php

namespace App\Repositories\Backend\Scrum\BacklogMeeting;

use App\Models\Scrum\BacklogMeeting\BacklogMeeting;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingCreated;
use App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingUpdated;
use App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingDeleted;
use App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingRestored;

/**
 * Class EloquentBacklogMeetingRepository
 * @package App\Repositories\BacklogMeeting
 */
class EloquentBacklogMeetingRepository implements BacklogMeetingRepositoryContract
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
        $backlogmeeting = $this->createBacklogMeetingStub($input);
        //TODO: set properties

		DB::transaction(function() use ($backlogmeeting) {
			if ($backlogmeeting->save()) {
				event(new BacklogMeetingCreated($backlogmeeting));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.backlogmeetings.create_error'));
		});
    }

    /**
     * @param BacklogMeeting $backlogmeeting
     * @param $input
     * @param $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(BacklogMeeting $backlogmeeting, $input)
    {
    	//TODO: set $input properties
    	
		DB::transaction(function() use ($backlogmeeting, $input) {
			if ($backlogmeeting->update($input)) {
				event(new BacklogMeetingUpdated($backlogmeeting));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.backlogmeetings.update_error'));
		});
    }
    /**
     * @param  BacklogMeeting $backlogmeeting
     * @throws GeneralException
     * @return bool
     */
    public function destroy(BacklogMeeting $backlogmeeting)
    {
        if ($backlogmeeting->delete()) {
            event(new BacklogMeetingDeleted($backlogmeeting));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.backlogmeetings.delete_error'));
    }

    /**
     * @param  BacklogMeeting $backlogmeeting
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(BacklogMeeting $backlogmeeting)
    {
        //Failsafe
        if (is_null($backlogmeeting->deleted_at)) {
            throw new GeneralException("This backlogmeeting must be deleted first before it can be destroyed permanently.");
        }

		DB::transaction(function() use ($backlogmeeting) {
			//TODO: delete related entities

			if ($backlogmeeting->forceDelete()) {
				event(new BacklogMeetingPermanentlyDeleted($backlogmeeting));
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.scrum.backlogmeetings.delete_error'));
		});
    }

    /**
     * @param  BacklogMeeting $backlogmeeting
     * @throws GeneralException
     * @return bool
     */
    public function restore(BacklogMeeting $backlogmeeting)
    {
        //Failsafe
        if (is_null($backlogmeeting->deleted_at)) {
            throw new GeneralException("This backlogmeeting is not deleted so it can not be restored.");
        }

        if ($backlogmeeting->restore()) {
            event(new BacklogMeetingRestored($backlogmeeting));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.backlogmeetings.restore_error'));
    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createBacklogMeetingStub($input)
    {
        $backlogmeeting                    = new BacklogMeeting;
        //TODO: set properties

        return $backlogmeeting;
    }
}
