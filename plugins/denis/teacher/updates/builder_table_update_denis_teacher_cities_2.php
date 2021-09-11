<?php namespace Denis\Teacher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDenisTeacherCities2 extends Migration
{
    public function up()
    {
        Schema::table('denis_teacher_cities', function($table)
        {
            $table->integer('cities_students')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('denis_teacher_cities', function($table)
        {
            $table->dropColumn('cities_students');
        });
    }
}
