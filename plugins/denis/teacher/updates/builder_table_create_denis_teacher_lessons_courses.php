<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherLessonsCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_lessons_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('courses_id');
            $table->integer('lessons_id');
            $table->primary(['courses_id','lessons_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_lessons_courses');
    }
}
