<?php
namespace App\Models\Scrum\UserStory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scrum\UserStory\Traits\Relationship\UserStoryRelationship;
use App\Models\Scrum\UserStory\Traits\UserStoryAccess;

/**
 * Class UserStory
 * 
 * @package App\Models\Scrum\UserStory
 */
class UserStory extends Model
{
    use SoftDeletes, UserStoryAccess, UserStoryRelationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scrum_user_stories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'role',
        'activity',
        'business_value',
        'description',
        'story_type',
        'priority',
        'story_points',
        'remarks',
        'INVEST'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = '';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
}
