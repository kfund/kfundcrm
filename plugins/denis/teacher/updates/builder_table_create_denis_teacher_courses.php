<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('courses_course')->nullable();
            $table->text('slug')->nullable();
            $table->text('age')->nullable();
            $table->date('date_of_start')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_courses');
    }
}
