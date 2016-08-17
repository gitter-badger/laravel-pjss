<?php

Breadcrumbs::register('admin.scrum.userstory.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.index');
    $breadcrumbs->push(trans('labels.backend.scrum.userstories.management'), route('admin.scrum.userstory.index'));
});

Breadcrumbs::register('admin.scrum.userstory.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.userstory.index');
    $breadcrumbs->push(trans('menus.backend.scrum.userstories.create'), route('admin.scrum.userstory.create'));
});

Breadcrumbs::register('admin.scrum.userstory.detail', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.userstory.index');
    $breadcrumbs->push(trans('menus.backend.scrum.userstories.detail'), route('admin.scrum.userstory.detail', $id));
});

Breadcrumbs::register('admin.scrum.userstory.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.userstory.index');
    $breadcrumbs->push(trans('menus.backend.scrum.userstories.edit'), route('admin.scrum.userstory.edit', $id));
});