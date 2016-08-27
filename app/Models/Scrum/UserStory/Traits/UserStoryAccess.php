<?php

namespace App\Models\Scrum\UserStory\Traits;

use App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria;
/**
 * Class UserStoryScrum
 * @package App\Models\Scrum\UserStory\Traits
 */
trait UserStoryAccess
{
    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param  mixed  $acceptance_criteria
     * @return void
     */
    public function attachAcceptanceCriteria($acceptance_criteria)
    {
        if (is_object($acceptance_criteria)) {
            $acceptance_criteria = $acceptance_criteria->getKey();
        }

        $this->acceptance_criterias()->create($acceptance_criteria);
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param  mixed  $acceptance_criteria
     * @return void
     */
    public function detachAcceptanceCriteria($acceptance_criteria)
    {
        if (is_object($acceptance_criteria)) {
            $acceptance_criteria = $acceptance_criteria->getKey();
        }

        $this->acceptance_criterias()->delete($acceptance_criteria);
    }

    /**
     * Attach multiple acceptance_criterias to a UserStory
     *
     * @param  mixed  $acceptance_criterias
     * @return void
     */
    public function attachAcceptanceCriterias($acceptance_criterias)
    {
        if (is_null($acceptance_criterias)) return;
        
        foreach ($acceptance_criterias as $acceptance_criteria) {
            $this->attachAcceptanceCriteria($acceptance_criteria);
        }
    }

    /**
     * Detach multiple acceptance_criterias from a UserStory
     *
     * @param  mixed  $acceptance_criterias
     * @return void
     */
    public function detachAcceptanceCriterias($acceptance_criterias)
    {
        if (is_null($acceptance_criterias)) return;
        
        foreach ($acceptance_criterias as $acceptance_criteria) {
            $this->detachAcceptanceCriteria($acceptance_criteria);
        }
    }
    
    /**
     * Save multiple acceptance_criterias from a UserStory
     *
     * @param  mixed  $acceptance_criterias
     * @return void
     */
    public function saveAcceptanceCriterias($acceptance_criterias)
    {
        if (is_null($acceptance_criterias)) return;
        
        // delete
        $oids = $this->acceptance_criterias->lists('id')->toArray();
        $nids = array_map(function($acceptance_criteria) {
           return (int)$acceptance_criteria['id'];
        }, $acceptance_criterias);
        $deletes = array_diff($oids, $nids);
        
        // delete 
        foreach ($deletes as $delete) {
            $this->acceptance_criterias()->where('id', $delete)->delete();
        }
        
        foreach ($acceptance_criterias as $acceptance_criteria) {
            if (!isset($acceptance_criteria['id']) || !$acceptance_criteria['id']) {
                // insert
                $this->acceptance_criterias()->create($acceptance_criteria);
            } else {
                // update
                $this->acceptance_criterias()->updateOrInsert(['id' => $acceptance_criteria['id']], $acceptance_criteria);
            }
        }
    }
}
