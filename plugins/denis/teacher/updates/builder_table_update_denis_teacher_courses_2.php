<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherCourses2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_courses', function($table)
        {
            $table->integer('lessons_count')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_courses', function($table)
        {
            $table->dropColumn('lessons_count');
        });
    }
}
