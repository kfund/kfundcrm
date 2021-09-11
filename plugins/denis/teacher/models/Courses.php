<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Courses extends Model
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
    public $table = 'denis_teacher_courses';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // relations

    public $belongsToMany = [

        'teacher' => [

            'Denis\Teacher\Models\Teacher',

            'table' => 'denis_teacher_teacher_courses',
            
            'order' => 'name'
        ],

        'schools' => [

            'Denis\Teacher\Models\Schools',

            'table' => 'denis_teacher_schools_courses',
            
            'order' => 'schools_school'
        ],

        'cities' => [

            'Denis\Teacher\Models\Cities',

            'table' => 'denis_teacher_cities_courses',
            
            'order' => 'cities_city'
        ],
        
        'lessons' => [

            'Denis\Teacher\Models\Lessons',

            'table' => 'denis_teacher_lessons_courses',
            
            'order' => 'lesson_name'
        ],
        
        'sprints' => [

            'Denis\Teacher\Models\Sprints',

            'table' => 'denis_teacher_sprints_courses',
            
            'order' => 'sprints_title'
        ]
    ];

    public $attachOne = [
        'courses_image' => 'System\Models\File',
        'curriculum' => 'System\Models\File'
    ];
}
