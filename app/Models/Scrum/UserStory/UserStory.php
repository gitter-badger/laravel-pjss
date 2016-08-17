<?php

namespace App\Models\Scrum\UserStory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserStory
 * @package App\Models\Scrum\UserStory
 */
class UserStory extends Model
{
	use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scrum_user_stories';
    
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = ['code', 'name'];
    
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
