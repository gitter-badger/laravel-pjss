<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Scrum\UserStory\Traits\Enum;
use App\Models\Scrum\UserStory\Traits\Enum\StoryTypeEnum;
use App\Models\Scrum\UserStory\Traits\Enum\INVESTEnum;

class CreateScrumUserStoriesTable extends Migration
{
    use StoryTypeEnum, INVESTEnum;
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrum_user_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->comment('项目ID');
            $table->string('code', 20)->comment('故事编号');
            $table->string('description')->comment('用户故事');
            $table->enum('story_type', $this->enum_story_type())->comment('故事类型');
            $table->smallInteger('priority')->comment('优先级');
            $table->smallInteger('story_points')->nullable()->default(DB::raw('NULL'))->comment('故事点数');
            $table->text('remarks')->comment('备注');
            $table->enum('INVEST', range(1, 63))->comment('INVEST原则');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at');
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
        Schema::drop('scrum_user_stories');
    }
}
