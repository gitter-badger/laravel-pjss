<?php

namespace App\Models\Scrum\Userstory;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
	use SoftDeletes;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'scrum_user_stories';
    
    /**
     * 模型的日期字段保存格式。
     *
     * @var string
     */
    protected $dateFormat = 'U';
    
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
