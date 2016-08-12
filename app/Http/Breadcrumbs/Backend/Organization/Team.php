<?php
Breadcrumbs::register('admin.organization.team.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.organization.management'), '#');
    $breadcrumbs->push(trans('labels.backend.organization.team.management'), route('admin.organization.team.index'));
});

Breadcrumbs::register('admin.organization.project.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.organization.management'), '#');
    $breadcrumbs->push(trans('labels.backend.organization.project.management'), route('admin.organization.project.index'));
});