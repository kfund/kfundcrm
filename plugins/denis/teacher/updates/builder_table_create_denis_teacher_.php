<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacher extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('name', 30);
            $table->string('city', 20);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_');
    }
}
