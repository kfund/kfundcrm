<?php namespace Denis\Teacher\Models;

use Model;

/**
 * Model
 */
class Lessons extends Model
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
    public $table = 'denis_teacher_lessons';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // Relations

    public $belongsToMany = [

    'courses' => [

        'Denis\Teacher\Models\Courses',

        'table' => 'denis_teacher_lessons_courses',
        
        'order' => 'courses_course'
    ],
    
    'sprints' => [
    
        'Denis\Teacher\Models\Sprints',

        'table' => 'denis_teacher_lessons_sprints',
        
        'order' => 'sprints_title'
    ]

    ];

    public $attachOne = [
        'course_file' => 'System\Models\File',
        'course_image_inner' => 'System\Models\File'
    ];
}
