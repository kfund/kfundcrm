<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherCities extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_cities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('city')->nullable();
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_cities');
    }
}
