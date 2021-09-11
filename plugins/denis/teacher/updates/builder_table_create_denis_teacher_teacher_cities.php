<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherTeacherCities extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_teacher_cities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('teacher_id');
            $table->integer('city_id');
            $table->primary(['teacher_id','city_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_teacher_cities');
    }
}
