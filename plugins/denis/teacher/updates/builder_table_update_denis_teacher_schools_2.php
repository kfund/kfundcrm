<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherSchools2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_schools', function($table)
        {
            $table->string('short_name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_schools', function($table)
        {
            $table->dropColumn('short_name');
        });
    }
}
