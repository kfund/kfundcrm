<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherLessons4 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->integer('number')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->dropColumn('number');
        });
    }
}
