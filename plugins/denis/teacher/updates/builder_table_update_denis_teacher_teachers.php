<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherTeachers extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_teachers', function($table)
        {
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_teachers', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
