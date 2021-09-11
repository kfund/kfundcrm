<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Schools extends Model
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
    public $table = 'denis_teacher_schools';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // relations

    public $belongsToMany = [

        'teacher' => [

            'Denis\Teacher\Models\Teacher',

            'table' => 'denis_teacher_teacher_schools',
            
            'order' => 'name'
        ],

        'cities' => [

            'Denis\Teacher\Models\Cities',

            'table' => 'denis_teacher_schools_cities',
            
            'order' => 'cities_city'
        ],

        'courses' => [

            'Denis\Teacher\Models\Courses',

            'table' => 'denis_teacher_schools_courses',
            
            'order' => 'courses_course'
        ]
    ];

    public $attachOne = [
        'document1' => 'System\Models\File',
        'document2' => 'System\Models\File',
        'school_image' => 'System\Models\File'
    ];
}
