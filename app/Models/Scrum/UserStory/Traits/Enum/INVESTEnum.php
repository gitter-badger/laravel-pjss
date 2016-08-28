<?php
namespace App\Models\Scrum\UserStory\Traits\Enum;

/**
 * Class INVESTEnum
 * 
 * @package App\Models\Scrum\UserStory\Traits\Enum
 */
trait INVESTEnum {
    public function enum_INVEST() {
        return [
            trans('enums.INVEST.independent') => 1,
            trans('enums.INVEST.negotiable') => 2,
            trans('enums.INVEST.valuable') => 4,
            trans('enums.INVEST.estimable') => 8,
            trans('enums.INVEST.small') => 16,
            trans('enums.INVEST.testable') => 32,
        ];
    }
}