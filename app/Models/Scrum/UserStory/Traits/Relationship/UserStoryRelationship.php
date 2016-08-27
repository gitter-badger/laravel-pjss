<?php

namespace App\Models\Scrum\UserStory\Traits\Relationship;

/**
 * Class UserStoryRelationship
 * @package App\Models\Scrum\UserStory\Traits\Relationship
 */
trait UserStoryRelationship
{

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acceptance_criterias()
    {
        return $this->hasMany(
            \App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria::class,
            'userstory_id', 'id');
    }
}