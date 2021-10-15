<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherLessons5 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->dropColumn('number_count');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->integer('number_count')->nullable();
        });
    }
}
