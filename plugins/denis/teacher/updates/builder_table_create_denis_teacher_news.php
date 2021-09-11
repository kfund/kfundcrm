<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenisTeacherNews extends Migration
{
    public function up()
    {
        Schema::create('denis_teacher_news', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('news')->nullable();
            $table->string('author')->nullable();
            $table->date('date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denis_teacher_news');
    }
}
