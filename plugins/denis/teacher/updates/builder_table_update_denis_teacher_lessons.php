<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherLessons extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->renameColumn('field3', 'short_description');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_lessons', function($table)
        {
            $table->renameColumn('short_description', 'field3');
        });
    }
}
