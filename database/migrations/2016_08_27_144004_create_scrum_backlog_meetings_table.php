<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrumBacklogMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrum_backlog_meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');//主题
            $table->dateTime('open_date');//召开日期
            $table->string('join_people');//参与人员
            $table->text('meeting_resolution');//会议决议
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
        Schema::drop('scrum_backlog_meetings');
    }
}
