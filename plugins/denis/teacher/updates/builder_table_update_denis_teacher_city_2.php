<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherCity2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_city', function($table)
        {
            $table->renameColumn('city', 'cityname');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_city', function($table)
        {
            $table->renameColumn('cityname', 'city');
        });
    }
}
