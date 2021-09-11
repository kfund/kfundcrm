<?php namespace Rebel59\Comments\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('rebel59_comments_comments', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('author_name');
            $table->string('author_email');
            $table->longText('content');
            $table->string('page_name')->nullable();
            $table->boolean('notify')->nullable();

            $table->string('attachment_type')->nullable();
            $table->integer('attachment_id')->nullable();

            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rebel59_comments_comments');
    }
}
