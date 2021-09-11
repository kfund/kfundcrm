<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherSchoolsCourses extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_schools_courses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('course_id');
            $table->integer('schools_id');
            $table->primary(['course_id','schools_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_schools_courses');
    }
}
