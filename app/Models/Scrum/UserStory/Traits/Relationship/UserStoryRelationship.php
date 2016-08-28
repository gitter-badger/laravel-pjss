<?php
namespace App\Models\Scrum\UserStory\Traits\Relationship;

/**
 * Class UserStoryRelationship
 * 
 * @package App\Models\Scrum\UserStory\Traits\Relationship
 */
trait UserStoryRelationship
{

    /**
     * One-to-Many relations with AcceptanceCriterias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acceptance_criterias()
    {
        return $this->hasMany(\App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria::class, 'user_story_id', 'id');
    }

    /**
     * One-to-One relations with LoFi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lo_fi()
    {
        return $this->hasOne(\App\Models\File\Media\Media::class, 'obj_id', 'id');
    }

    /**
     * One-to-One relations with HiFi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hi_fi()
    {
        return $this->hasOne(\App\Models\File\Media\Media::class, 'obj_id', 'id');
    }

    /**
     * One-to-Many relations with Attachments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attachments()
    {
        return $this->hasMany(\App\Models\File\Media\Media::class, 'obj_id', 'id');
    }
}