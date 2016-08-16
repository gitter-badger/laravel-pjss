<?php

namespace App\Repositories\Frontend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Frontend\Scrum\UserStory\UserStoryCreated;
use App\Events\Frontend\Scrum\UserStory\UserStoryUpdated;
use App\Events\Frontend\Scrum\UserStory\UserStoryDeleted;
use App\Events\Frontend\Scrum\UserStory\UserStoryRestored;

/**
 * Class EloquentUserStoryRepository
 * @package App\Repositories\UserStory
 */
class EloquentUserStoryRepository implements UserStoryRepositoryContract
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
        $userstory = $this->createUserStoryStub($input);

		DB::transaction(function() use ($userstory) {
			if ($userstory->save()) {
				//TODO: set properties
				
				event(new UserStoryCreated($userstory));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.userstories.create_error'));
		});
    }

    /**
     * @param UserStory $userstory
     * @param $input
     * @param $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(UserStory $userstory, $input, $roles)
    {
        $this->checkUserStoryByEmail($input, $userstory);

		DB::transaction(function() use ($userstory, $input, $roles) {
			if ($userstory->update($input)) {
				//TODO: set properties

				$userstory->save();

				event(new UserStoryUpdated($userstory));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.userstories.update_error'));
		});
    }
    /**
     * @param  UserStory $userstory
     * @throws GeneralException
     * @return bool
     */
    public function destroy(UserStory $userstory)
    {
        if ($userstory->delete()) {
            event(new UserStoryDeleted($userstory));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.userstories.delete_error'));
    }

    /**
     * @param  UserStory $userstory
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(UserStory $userstory)
    {
        //Failsafe
        if (is_null($userstory->deleted_at)) {
            throw new GeneralException("This userstory must be deleted first before it can be destroyed permanently.");
        }

		DB::transaction(function() use ($userstory) {
			//TODO: delete related entities

			if ($userstory->forceDelete()) {
				event(new UserStoryPermanentlyDeleted($userstory));
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.scrum.userstories.delete_error'));
		});
    }

    /**
     * @param  UserStory $userstory
     * @throws GeneralException
     * @return bool
     */
    public function restore(UserStory $userstory)
    {
        //Failsafe
        if (is_null($userstory->deleted_at)) {
            throw new GeneralException("This userstory is not deleted so it can not be restored.");
        }

        if ($userstory->restore()) {
            event(new UserStoryRestored($userstory));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.userstories.restore_error'));
    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createUserStoryStub($input)
    {
        $userstory                    = new UserStory;
        //TODO: set properties

        return $userstory;
    }
}
