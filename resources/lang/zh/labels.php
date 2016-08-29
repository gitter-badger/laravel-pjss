<?php
return [
    
    /*
     * |--------------------------------------------------------------------------
     * | Labels Language Lines
     * |--------------------------------------------------------------------------
     * |
     * | The following language lines are used in labels throughout the system.
     * | Regardless where it is placed, a label can be listed here so it is easily
     * | found in a intuitive way.
     * |
     */
    
    'general' => [
        'all' => 'All',
        'yes' => 'Yes',
        'no' => 'No',
        'custom' => 'Custom',
        'actions' => 'Actions',
        'buttons' => [
            'save' => 'Save',
            'update' => 'Update'
        ],
        'hide' => 'Hide',
        'none' => 'None',
        'show' => 'Show',
        'toggle_navigation' => 'Toggle Navigation'
    ],
    
    'backend' => [
       'management' => 'File Management',
        'file' => [/*backend*/
            'media' => [
                'management' => 'media',
            ],
        ],
        'scrum' => [/*backend*/
            'meetings' => [
                'management' => 'meeting',
            ],
            'backlogmeetings' => [
                'management' => '梳理会议',
            ],
            'acceptancecriterias' => [
                'management' => 'acceptancecriteria',
            ],
            'management' => '敏捷',
            'userstories' => [
                'management' => '用户故事',
            ],
        ],
        'access' => [
            'roles' => [
                'create' => 'Create Role',
                'edit' => 'Edit Role',
                'management' => 'Role Management',
                
                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions' => 'Permissions',
                    'role' => 'Role',
                    'sort' => 'Sort',
                    'total' => 'role total|roles total'
                ]
            ],
            
            'users' => [
                'active' => 'Active Users',
                'all_permissions' => 'All Permissions',
                'change_password' => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create' => 'Create User',
                'deactivated' => 'Deactivated Users',
                'deleted' => 'Deleted Users',
                'edit' => 'Edit User',
                'management' => 'User Management',
                'no_permissions' => 'No Permissions',
                'no_roles' => 'No Roles to set.',
                'permissions' => 'Permissions',
                
                'table' => [
                    'confirmed' => 'Confirmed',
                    'created' => 'Created',
                    'email' => 'E-mail',
                    'id' => 'ID',
                    'last_updated' => 'Last Updated',
                    'name' => 'Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted' => 'No Deleted Users',
                    'roles' => 'Roles',
                    'total' => 'user total|users total'
                ]
            ]
        ],
        'organization' => [
            'management' => '组织架构',
            'project' => [
                'management' => '项目'
            ],
            'team' => [
                'management' => '团队'
            ]
        ]
    ],
    
    'frontend' => [
       'management' => 'File Management',
        'file' => [/*frontend*/
            'media' => [
                'management' => 'media',
            ],
        ],
        'scrum' => [/*frontend*/
            'meetings' => [
                'management' => 'meeting',
            ],
            'backlogmeetings' => [
                'management' => 'backlogmeeting',
            ],
            'acceptancecriterias' => [
                'management' => 'acceptancecriteria',
            ],
            'userstories' => [
                'management' => 'userstory',
            ],
        ],
        
        'auth' => [
            'login_box_title' => 'Login',
            'login_button' => 'Login',
            'login_with' => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button' => 'Register',
            'remember_me' => 'Remember Me'
        ],
        
        'passwords' => [
            'forgot_password' => 'Forgot Your Password?',
            'reset_password_box_title' => 'Reset Password',
            'reset_password_button' => 'Reset Password',
            'send_password_reset_link_button' => 'Send Password Reset Link'
        ],
        
        'macros' => [
            'country' => [
                'alpha' => 'Country Alpha Codes',
                'alpha2' => 'Country Alpha 2 Codes',
                'alpha3' => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes'
            ],
            
            'macro_examples' => 'Macro Examples',
            
            'state' => [
                'mexico' => 'Mexico State List',
                'us' => [
                    'us' => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed' => 'US Armed Forces'
                ]
            ],
            
            'territories' => [
                'canada' => 'Canada Province & Territories List'
            ],
            
            'timezone' => 'Timezone'
        ],
        
        'user' => [
            'passwords' => [
                'change' => 'Change Password'
            ],
            
            'profile' => [
                'avatar' => 'Avatar',
                'created_at' => 'Created At',
                'edit_information' => 'Edit Information',
                'email' => 'E-mail',
                'last_updated' => 'Last Updated',
                'name' => 'Name',
                'update_information' => 'Update Information'
            ]
        ]
    ]
    
];
