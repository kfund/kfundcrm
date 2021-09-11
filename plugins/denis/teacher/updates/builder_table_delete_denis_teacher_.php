<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteDenisTeacher extends Migration
{
    public function up()
    {
        Schema::dropIfExists('denis_teacher_');
    }
    
    public function down()
    {
        Schema::create('denis_teacher_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('name', 30);
            $table->string('city', 20);
        });
    }
}
