<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->dropColumn('documents');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->text('documents')->nullable();
        });
    }
}
