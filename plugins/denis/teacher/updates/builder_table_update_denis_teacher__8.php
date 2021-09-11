<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher8 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->string('status')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
