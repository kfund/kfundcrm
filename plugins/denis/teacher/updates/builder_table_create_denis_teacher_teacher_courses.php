<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherTeacherCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_teacher_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('courses_id');
            $table->integer('teacher_id');
            $table->primary(['courses_id','teacher_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_teacher_courses');
    }
}
