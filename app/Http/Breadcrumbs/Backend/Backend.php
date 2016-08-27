<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.dashboard'));
});

require __DIR__ . '/Access.php';
require __DIR__ . '/LogViewer.php';
require __DIR__ . '/Organization.php';
// Scrum Require
require __DIR__ . '/Scrum.php';
// File Require
require __DIR__ . '/File.php';