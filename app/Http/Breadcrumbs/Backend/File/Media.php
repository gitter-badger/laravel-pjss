<?php
Breadcrumbs::register('admin.file.media.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.index');
    $breadcrumbs->push(trans('labels.backend.file.media.management'), route('admin.file.media.index'));
});

Breadcrumbs::register('admin.file.media.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.media.index');
    $breadcrumbs->push(trans('menus.backend.file.media.create'), route('admin.file.media.create'));
});

Breadcrumbs::register('admin.file.media.detail', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.media.index');
    $breadcrumbs->push(trans('menus.backend.file.media.detail'), route('admin.file.media.detail', $id));
});

Breadcrumbs::register('admin.file.media.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.media.index');
    $breadcrumbs->push(trans('menus.backend.file.media.edit'), route('admin.file.media.edit', $id));
});