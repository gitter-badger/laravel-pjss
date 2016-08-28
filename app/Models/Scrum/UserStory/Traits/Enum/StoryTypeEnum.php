<?php
namespace App\Models\Scrum\UserStory\Traits\Enum;

/**
 * Class StoryTypeEnum
 * 
 * @package App\Models\Scrum\UserStory\Traits\Enum
 */
trait StoryTypeEnum {
    public function enum_story_type() {
        return [
            trans('enums.story_type.functional') => 1,
            trans('enums.story_type.technical') => 2,
        ];
    }
}