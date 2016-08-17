<?php

Breadcrumbs::register('admin.scrum.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.scrum.management'), '#');
});

// UserStory Require
require __DIR__ . '/Scrum/UserStory.php';