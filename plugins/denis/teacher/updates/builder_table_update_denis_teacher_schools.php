<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherSchools extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_schools', function($table)
        {
            $table->date('start_date')->nullable();
            $table->dropColumn('start_year');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_schools', function($table)
        {
            $table->dropColumn('start_date');
            $table->integer('start_year')->nullable();
        });
    }
}
