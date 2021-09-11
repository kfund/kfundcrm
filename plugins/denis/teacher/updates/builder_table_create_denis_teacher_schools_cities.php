<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherSchoolsCities extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_schools_cities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('cities_id');
            $table->integer('schools_id');
            $table->primary(['cities_id','schools_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_schools_cities');
    }
}
