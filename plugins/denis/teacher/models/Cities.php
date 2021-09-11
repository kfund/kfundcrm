<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Cities extends Model
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
    public $table = 'denis_teacher_cities';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // Relations

    public $belongsToMany = [

        'teacher' => [

            'Denis\Teacher\Models\Teacher',

            'table' => 'denis_teacher_teacher_cities',
            
            'order' => 'name'
        ],

        'schools' => [

            'Denis\Teacher\Models\Schools',

            'table' => 'denis_teacher_schools_cities',
            
            'order' => 'schools_school'
        ],

        'courses' => [

            'Denis\Teacher\Models\Courses',

            'table' => 'denis_teacher_cities_courses',
            
            'order' => 'courses_course'
        ]
        ];
}
