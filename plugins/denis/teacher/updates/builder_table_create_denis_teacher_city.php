<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherCity extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_city', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_city');
    }
}
