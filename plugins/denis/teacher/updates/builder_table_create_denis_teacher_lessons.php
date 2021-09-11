<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherLessons extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_lessons', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('lesson_name')->nullable();
            $table->string('slug')->nullable();
            $table->text('field1')->nullable();
            $table->text('field2')->nullable();
            $table->text('field3')->nullable();
            $table->string('video_link_1')->nullable();
            $table->string('video_link_2')->nullable();
            $table->string('material_link_1')->nullable();
            $table->string('material_link_2')->nullable();
            $table->string('presentation_link')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_lessons');
    }
}
