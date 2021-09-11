<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherTeacherCities extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->dropPrimary(['teacher_id','city_id']);
            $table->renameColumn('city_id', 'cities_id');
            $table->primary(['teacher_id','cities_id']);
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->dropPrimary(['teacher_id','cities_id']);
            $table->renameColumn('cities_id', 'city_id');
            $table->primary(['teacher_id','city_id']);
        });
    }
}
