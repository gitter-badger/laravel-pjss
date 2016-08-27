<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrumBacklogMeetingsStorylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrum_backlog_meetings_storylist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_story_id')->unsigned();//用户故事主键
            $table->dateTime('is_accept');//是否接受需求
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scrum_backlog_meetings_storylist', function (Blueprint $table) {
            //
        });
    }
}
