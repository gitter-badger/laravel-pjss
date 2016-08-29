<?php

Breadcrumbs::register('admin.scrum.meeting.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.index');
    $breadcrumbs->push(trans('labels.backend.scrum.meetings.management'), route('admin.scrum.meeting.index'));
});

Breadcrumbs::register('admin.scrum.meeting.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.meeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.meetings.create'), route('admin.scrum.meeting.create'));
});

Breadcrumbs::register('admin.scrum.meeting.detail', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.meeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.meetings.detail'), route('admin.scrum.meeting.detail', $id));
});

Breadcrumbs::register('admin.scrum.meeting.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.meeting.index');
    $breadcrumbs->push(trans('menus.backend.scrum.meetings.edit'), route('admin.scrum.meeting.edit', $id));
});