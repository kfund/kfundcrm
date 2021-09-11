<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherSchoolsCourses extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_schools_courses', function($table)
        {
            $table->dropPrimary(['course_id','schools_id']);
            $table->renameColumn('course_id', 'courses_id');
            $table->primary(['courses_id','schools_id']);
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_schools_courses', function($table)
        {
            $table->dropPrimary(['courses_id','schools_id']);
            $table->renameColumn('courses_id', 'course_id');
            $table->primary(['course_id','schools_id']);
        });
    }
}
