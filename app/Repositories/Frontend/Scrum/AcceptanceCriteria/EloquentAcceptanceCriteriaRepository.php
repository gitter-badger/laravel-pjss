<?php

namespace App\Repositories\Frontend\Scrum\AcceptanceCriteria;

use App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaCreated;
use App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaUpdated;
use App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaDeleted;
use App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaRestored;

/**
 * Class EloquentAcceptanceCriteriaRepository
 * @package App\Repositories\AcceptanceCriteria
 */
class EloquentAcceptanceCriteriaRepository implements AcceptanceCriteriaRepositoryContract
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
        $acceptancecriteria = $this->createAcceptanceCriteriaStub($input);
        //TODO: set properties

		DB::transaction(function() use ($acceptancecriteria) {
			if ($acceptancecriteria->save()) {
				event(new AcceptanceCriteriaCreated($acceptancecriteria));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.acceptancecriterias.create_error'));
		});
    }

    /**
     * @param AcceptanceCriteria $acceptancecriteria
     * @param $input
     * @param $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(AcceptanceCriteria $acceptancecriteria, $input)
    {
    	//TODO: set $input properties
    	
		DB::transaction(function() use ($acceptancecriteria, $input) {
			if ($acceptancecriteria->update($input)) {
				event(new AcceptanceCriteriaUpdated($acceptancecriteria));
				return true;
			}

        	throw new GeneralException(trans('exceptions.backend.scrum.acceptancecriterias.update_error'));
		});
    }
    /**
     * @param  AcceptanceCriteria $acceptancecriteria
     * @throws GeneralException
     * @return bool
     */
    public function destroy(AcceptanceCriteria $acceptancecriteria)
    {
        if ($acceptancecriteria->delete()) {
            event(new AcceptanceCriteriaDeleted($acceptancecriteria));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.acceptancecriterias.delete_error'));
    }

    /**
     * @param  AcceptanceCriteria $acceptancecriteria
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(AcceptanceCriteria $acceptancecriteria)
    {
        //Failsafe
        if (is_null($acceptancecriteria->deleted_at)) {
            throw new GeneralException("This acceptancecriteria must be deleted first before it can be destroyed permanently.");
        }

		DB::transaction(function() use ($acceptancecriteria) {
			//TODO: delete related entities

			if ($acceptancecriteria->forceDelete()) {
				event(new AcceptanceCriteriaPermanentlyDeleted($acceptancecriteria));
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.scrum.acceptancecriterias.delete_error'));
		});
    }

    /**
     * @param  AcceptanceCriteria $acceptancecriteria
     * @throws GeneralException
     * @return bool
     */
    public function restore(AcceptanceCriteria $acceptancecriteria)
    {
        //Failsafe
        if (is_null($acceptancecriteria->deleted_at)) {
            throw new GeneralException("This acceptancecriteria is not deleted so it can not be restored.");
        }

        if ($acceptancecriteria->restore()) {
            event(new AcceptanceCriteriaRestored($acceptancecriteria));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.scrum.acceptancecriterias.restore_error'));
    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createAcceptanceCriteriaStub($input)
    {
        $acceptancecriteria                    = new AcceptanceCriteria;
        //TODO: set properties

        return $acceptancecriteria;
    }
}
