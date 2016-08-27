<?php
Breadcrumbs::register('admin.file.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.file.management'), '#');
});

// Media Require
require __DIR__ . '/File/Media.php';