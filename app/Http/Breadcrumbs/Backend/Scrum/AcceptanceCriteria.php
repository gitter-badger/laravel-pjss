<?php
Breadcrumbs::register('admin.scrum.acceptancecriteria.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.index');
    $breadcrumbs->push(trans('labels.backend.scrum.acceptancecriterias.management'), route('admin.scrum.acceptancecriteria.index'));
});

Breadcrumbs::register('admin.scrum.acceptancecriteria.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.scrum.acceptancecriteria.index');
    $breadcrumbs->push(trans('menus.backend.scrum.acceptancecriterias.create'), route('admin.scrum.acceptancecriteria.create'));
});

Breadcrumbs::register('admin.scrum.acceptancecriteria.detail', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.acceptancecriteria.index');
    $breadcrumbs->push(trans('menus.backend.scrum.acceptancecriterias.detail'), route('admin.scrum.acceptancecriteria.detail', $id));
});

Breadcrumbs::register('admin.scrum.acceptancecriteria.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.scrum.acceptancecriteria.index');
    $breadcrumbs->push(trans('menus.backend.scrum.acceptancecriterias.edit'), route('admin.scrum.acceptancecriteria.edit', $id));
});