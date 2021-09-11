<?php

return [
    'plugin' => [
        'title' => 'Comments',
        'description' => 'A robust comment platform.',
        'settings_name' => 'Comments',
        'settings_description' => 'External Model relationships',
    ],
    'components' => [
        'comments' => [
            'title' => 'Comments',
            'description' => 'Shows a list of comments and a new comment form.',
            'properties' => [
                'name' => 'Comments',
                'description' => 'Displays comments for the requested URL.',
                'groups' => [
                    'assets' => 'Assets',
                    'disableComments' => 'Disable Comments',
                    'sorting' => 'Sorting',
                    'unsubscribe' => 'Unsubscribing',
                    'relations' => 'Relations',
                ],
                'loadCss' => [
                    'title' => 'Load Plugin CSS',
                    'description' => 'Check this if you want to load the predefined CSS that comes bundled with plugin.'
                ],
                'loadJs' => [
                    'title' => 'Load Plugin JS',
                    'description' => 'Check this if you want to load the predefined JS that comes bundled with plugin.'
                ],
                'disableComments' => [
                    'title' => 'Disable Comments',
                    'description' => 'Disables the functionality to post new comments for this page.'
                ],
                'disableGuestComments' => [
                    'title' => 'Disable Guest Comments',
                    'description' => 'Disables the functionality for guest users to post new comments for this page.'
                ],
                'registerPage' => [
                    'title' => 'Register Page',
                    'description' => 'The page where users should register.'
                ],
                'listElement' => [
                    'title' => 'Comment List Element',
                    'description' => 'The HTML element that contains the comments.'
                ],
                'location' => [
                    'title' => 'New Comment Location',
                    'description' => 'Determines where new comments are placed.',
                    'underComments' => 'Under existing comments',
                    'aboveComments' => 'Above existing comments'
                ],
                'commentsPerPage' => [
                    'title' => 'Comments per page',
                    'description' => 'The number of comments that should be shown on one page.',
                    'validationMessage' => 'Invalid format. Should be an integer.'
                ],
                'pageNumber' => [
                    'title' => 'Page number',
                    'description' => 'This value is used to determine what page the user is on.'
                ],
                'unsubscribePage' => [
                    'title' => 'Unsubcribe Page',
                    'description' => 'The filename of the page that has the unsubscribe component.'
                ],
                'externalRelation' => [
                    'title' => 'External Relation',
                    'description' => '@TODO'
                ],
                'externalRelationParam' => [
                    'title' => 'Relation Parameter',
                    'description' => 'The parameter belonging to the external relation.'
                ],
            ]
        ],
        'unsubscribe' => [
            'title' => 'Unsubcribe',
            'description' => 'Shows a forms to unsubscribe from email notifcations.',
            'properties' => [
                'name' => 'Unsubscribe',
                'description' => 'Unsubscribe from email notifications based on a token.',
                'token' => [
                    'title' => 'Token',
                    'description' => 'This value determines the value of the token that is used to unsubscribe a user from the comment notifications.'
                ]
            ]
        ]
    ],
    'models' => [
        'comment' => [
            'author_name' => 'Author name',
            'author_email' => 'Author email',
            'content' => 'Content',
            'created_at' => 'Posted on',
            'notify' => 'Notify',
            'page_name' => 'Page Name',
        ],
        'settings' => [
            'relations' => 'Relations',
            'plugin_name' => 'Plugin name',
            'model_name' => 'Model name',
        ]
    ]
];