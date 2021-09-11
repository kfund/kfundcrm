<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherCities extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_cities', function($table)
        {
            $table->renameColumn('city', 'cities_city');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_cities', function($table)
        {
            $table->renameColumn('cities_city', 'city');
        });
    }
}
