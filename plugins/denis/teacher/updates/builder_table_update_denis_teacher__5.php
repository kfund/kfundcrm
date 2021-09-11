<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher5 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->renameColumn('python', 'python_skills');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->renameColumn('python_skills', 'python');
        });
    }
}
