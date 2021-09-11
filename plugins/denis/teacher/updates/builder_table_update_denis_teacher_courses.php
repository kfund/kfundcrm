<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherCourses extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_courses', function($table)
        {
            $table->renameColumn('age', 'students_age');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_courses', function($table)
        {
            $table->renameColumn('students_age', 'age');
        });
    }
}
