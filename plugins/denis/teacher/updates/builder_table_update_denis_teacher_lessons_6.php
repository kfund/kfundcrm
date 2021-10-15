<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherLessons6 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->renameColumn('number', 'number_count');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->renameColumn('number_count', 'number');
        });
    }
}
