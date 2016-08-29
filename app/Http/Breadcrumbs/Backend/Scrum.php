<?php
Breadcrumbs::register('admin.scrum.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.scrum.management'), '#');
});

// UserStory Require
require __DIR__ . '/Scrum/UserStory.php';
// AcceptanceCriteria Require
require __DIR__ . '/Scrum/AcceptanceCriteria.php';
// BacklogMeeting Require
require __DIR__ . '/Scrum/BacklogMeeting.php';
// Meeting Require
require __DIR__ . '/Scrum/Meeting.php';