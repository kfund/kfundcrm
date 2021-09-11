<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherSprints extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_sprints', function($table)
        {
            $table->renameColumn('title', 'sprints_title');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_sprints', function($table)
        {
            $table->renameColumn('sprints_title', 'title');
        });
    }
}
