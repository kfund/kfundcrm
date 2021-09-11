<?php namespace Denis\Teacher\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Schools extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'desnis_teacher.manage_schools' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Denis.Teacher', 'Teachers', 'Schools');
    }
}
