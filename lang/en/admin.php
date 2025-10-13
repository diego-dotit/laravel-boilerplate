<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
    ],
    'users' => [
        'title' => 'Users',
        'singular' => 'user',
        'fields' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Enter name',
                'helper' => 'Full name of the user.',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter email',
                'helper' => 'Email address of the user.',
            ],
            'role' => [
                'label' => 'Role',
                'placeholder' => 'Select role',
                'helper' => 'Role assigned to the user.',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter password',
                'helper' => 'Password must be at least 8 characters.',
                'optional' => 'Leave blank to keep the current password.',
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'placeholder' => 'Confirm password',
                'helper' => 'Re-enter the password for confirmation.',
            ],
            'avatar' => [
                'label' => 'Profile picture',
            ],
        ],
    ],
];
