<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacher4 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->binary('document2')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_', function($table)
        {
            $table->dropColumn('document2');
        });
    }
}
