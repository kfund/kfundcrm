<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherSprintsCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_sprints_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('courses_id');
            $table->integer('sprints_id');
            $table->primary(['courses_id','sprints_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_sprints_courses');
    }
}
