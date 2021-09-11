<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 15:46
 */
namespace IdeaVerum\Intranet\Updates;
use Schema;
use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\File;
class Version_1_0_0 extends Migration{

    public function up(){

        // create ideaverum inside storage
        if(!File::isDirectory(storage_path('ideaverum')))
            File::makeDirectory(storage_path('ideaverum'));

        // create intranet inside storage/ideaverum
        if(!File::isDirectory(storage_path('ideaverum/intranet')))
            File::makeDirectory(storage_path('ideaverum/intranet'));

        // create uncategorized folder
        if(!File::isDirectory(storage_path('ideaverum/intranet/1')))
            File::makeDirectory(storage_path('ideaverum/intranet/1'));

        // create secure folder
        if(!File::isDirectory(storage_path('ideaverum/intranet/2')))
            File::makeDirectory(storage_path('ideaverum/intranet/2'));

        if(!Schema::hasTable('ideaverum_intranet_categories')){
            Schema::create('ideaverum_intranet_categories', function ($table){
                $table->increments('id');
                $table->string("title");
                $table->integer("parent_id")->default(0);
                $table->boolean('is_default')->default(0);
                $table->boolean('is_secure')->default(0);
                $table->integer('owner')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if(!Schema::hasTable('ideaverum_intranet_category_files')){
            Schema::create('ideaverum_intranet_category_files', function ($table){
                $table->increments('id');
                $table->integer('category_id');
                $table->integer("author"); // User id
                $table->string("filename");
                $table->string("original_filename");
                $table->boolean("is_deletable");
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('ideaverum_intranet_categories');
        Schema::dropIfExists('ideaverum_intranet_category_files');
    }

}
