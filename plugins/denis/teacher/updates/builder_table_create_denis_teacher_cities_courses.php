<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherCitiesCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_cities_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('courses_id');
            $table->integer('cities_id');
            $table->primary(['courses_id','cities_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_cities_courses');
    }
}
