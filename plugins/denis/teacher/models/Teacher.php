<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Teacher extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'denis_teacher_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // Relations

    public $belongsToMany = [

        'cities' => [

            'Denis\Teacher\Models\Cities',

            'table' => 'denis_teacher_teacher_cities',
            
            'order' => 'cities_city'
        ],

        'schools' => [

            'Denis\Teacher\Models\Schools',

            'table' => 'denis_teacher_teacher_schools',
            
            'order' => 'schools_school'
        ],

        'courses' => [

            'Denis\Teacher\Models\Courses',

            'table' => 'denis_teacher_teacher_courses',
            
            'order' => 'courses_course'
        ]

        ];

    public $attachOne = [
        'document_1' => 'System\Models\File',
        'image' => 'System\Models\File'
    ];
}
