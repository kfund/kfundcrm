<?php namespace Denis\Teacher\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Teachers extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'denis_teacher.manage_teachers' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Denis.Teacher', 'Teachers', 'Teacher');
    }
}
