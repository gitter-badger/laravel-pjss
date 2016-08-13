<?php

namespace App\Models\Scrum\Userstory;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
	use SoftDeletes;

    /**
     * ��ģ�͹��������ݱ�
     *
     * @var string
     */
    protected $table = 'scrum_user_stories';
    
    /**
     * ģ�͵������ֶα����ʽ��
     *
     * @var string
     */
    protected $dateFormat = 'U';
    
    /**
     * ��Ҫ��ת�������ڵ����ԡ�
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
