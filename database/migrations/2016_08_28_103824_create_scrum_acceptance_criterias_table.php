<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrumAcceptanceCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrum_acceptance_criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_story_id')->unsigned()->comment('用户故事ID');
            $table->string('condition')->comment('验收标准');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
            $table->softDeletes();
            
            $table->foreign('user_story_id')
                ->references('id')->on('scrum_user_stories')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scrum_acceptance_criterias');
    }
}
