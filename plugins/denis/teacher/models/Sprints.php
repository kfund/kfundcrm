<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Sprints extends Model
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
    public $table = 'denis_teacher_sprints';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // Relations

    public $belongsToMany = [

        'lessons' => [
    
            'Denis\Teacher\Models\Lessons',
    
            'table' => 'denis_teacher_lessons_sprints',
            
            'order' => 'lesson_name'
        ],

        'courses' => [

            'Denis\Teacher\Models\Courses',

            'table' => 'denis_teacher_sprints_courses',
            
            'order' => 'courses_course'
        ]
        ];
}
