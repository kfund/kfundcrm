<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherTeacherCities5 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->primary(['cities_id']);
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->dropPrimary(['cities_id']);
        });
    }
}
