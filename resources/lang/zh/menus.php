<?php
return [
    
    /*
     * |--------------------------------------------------------------------------
     * | Menus Language Lines
     * |--------------------------------------------------------------------------
     * |
     * | The following language lines are used in menu items throughout the system.
     * | Regardless where it is placed, a menu item can be listed here so it is easily
     * | found in a intuitive way.
     * |
     */
    
    'backend' => [
        'scrum' => [/*backend*/
            'acceptancecriterias' => [
                'create' => 'Create AcceptanceCriteria',
                'detail' => 'Information AcceptanceCriteria',
                'edit' => 'Edit AcceptanceCriteria',
            ],
            'userstories' => [
                'create' => '创建用户故事',
                'detail' => '用户故事详情',
                'edit' => '编辑用户故事',
            ],
        ],
        'access' => [
            'title' => 'Access Management',
            
            'roles' => [
                'all' => 'All Roles',
                'create' => 'Create Role',
                'edit' => 'Edit Role',
                'management' => 'Role Management',
                'main' => 'Roles'
            ],
            
            'users' => [
                'all' => 'All Users',
                'change-password' => 'Change Password',
                'create' => 'Create User',
                'deactivated' => 'Deactivated Users',
                'deleted' => 'Deleted Users',
                'edit' => 'Edit User',
                'main' => 'Users'
            ]
        ],
        
        'log-viewer' => [
            'main' => 'Log Viewer',
            'dashboard' => 'Dashboard',
            'logs' => 'Logs'
        ],
        
        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general' => 'General',
            'organization' => [
                'index' => '组织',
                'project' => '项目',
                'team' => '团队'
            ],
            'scrum' => [
                'index' => '敏捷',
                'userstory' => '用户故事'
            ]
        ]
        
    ],
    
    'language-picker' => [
        'language' => '中文',
        /**
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'ar' => 'Arabic',
            'da' => 'Danish',
            'de' => 'German',
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'it' => 'Italian',
            'pt-BR' => 'Brazilian Portuguese',
            'sv' => 'Swedish',
            'th' => 'Thai',
            'zh' => '中文'
        ]
    ]
];
