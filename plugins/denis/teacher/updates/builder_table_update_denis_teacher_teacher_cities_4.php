<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherTeacherCities4 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->renameColumn('teacher_id', 'teacher_profile_id');
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_teacher_cities', function($table)
        {
            $table->renameColumn('teacher_profile_id', 'teacher_id');
        });
    }
}
