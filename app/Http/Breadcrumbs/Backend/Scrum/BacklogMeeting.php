<?php

Breadcrumbs::register('admin.scrum.backlogmeeting.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.index');
    $breadcrumbs->push(trans('labels.backend.scrum.backlogmeetings.management'), route('admin.scrum.backlogmeeting.index'));
});

Breadcrumbs::register('admin.scrum.backlogmeeting.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.backlogmeeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.backlogmeetings.create'), route('admin.scrum.backlogmeeting.create'));
});

Breadcrumbs::register('admin.scrum.backlogmeeting.detail', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.backlogmeeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.backlogmeetings.detail'), route('admin.scrum.backlogmeeting.detail', $id));
});

Breadcrumbs::register('admin.scrum.backlogmeeting.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.backlogmeeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.backlogmeetings.edit'), route('admin.scrum.backlogmeeting.edit', $id));
});