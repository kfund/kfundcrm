<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 14:20
 */


namespace IdeaVerum\Intranet;

use Backend\Facades\Backend;
use Backend\Models\BrandSetting;
use IdeaVerum\Intranet\Contracts\IntranetCategoryFile;
use IdeaVerum\Intranet\Contracts\IntranetRepository;
use IdeaVerum\Intranet\Controllers\Files;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use System\Classes\PluginBase;


class Plugin extends PluginBase{

    public function pluginDetails()
    {
        return [
            'name' => 'ideaverum.intranet::lang.plugin.name',
            'description' => 'ideaverum.intranet::lang.plugin.description',
            'author' => 'IDEA VERUM',
            'iconSvg' =>'plugins/ideaverum/intranet/assets/img/icon.svg',
            'homepage' => 'https://www.ideaverum.hr'
        ];
    }

    public function registerNavigation()
    {
        return [
            'intranet' => [
                'label' => 'Intranet',
                'code' => 'intranet',
                'url' => Backend::url('ideaverum/intranet/files'),
                'iconSvg' => 'plugins/ideaverum/intranet/assets/img/icon.svg',
                'order' => 100,
                'permissions' => [
                    'ideaverum.intranet.access_intranet',
                ],
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'ideaverum.intranet.access_intranet' => [
                'tab' => 'ideaverum.intranet::lang.plugin.name',
                'label' => 'ideaverum.intranet::lang.permission.access_intranet'
            ],
            'ideaverum.intranet.secure_category' => [
                'tab' => 'ideaverum.intranet::lang.plugin.name',
                'label' => 'ideaverum.intranet::lang.permission.secure_category_label'
            ]
        ];
    }

    public function registerMailLayouts()
    {
        return [
            'intranet' => 'ideaverum.intranet::layouts.intranet'
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'ideaverum.intranet::mail.fileshare'
        ];
    }

    public function register()
    {

    }

    public function boot()
    {
        $this->app->bind(IntranetRepository::class,\IdeaVerum\Intranet\Repository\IntranetRepository::class);

        Route::group(['middleware'=>'web'],function(){
            Route::post(config('cms.backendUri').'/ideaverum/intranet/save-file',['as'=>'saveFileRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@saveFile']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/get-files',['as'=>'getFilesRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@getFiles']);
            Route::get( config('cms.backendUri').'/ideaverum/intranet/read-file/{file_id?}',['as'=>'readFileRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@readFile']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/save_category',['as'=>'saveCategoryRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@saveCategory']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/delete-category',['as'=>'deleteCategoryRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@deleteCategory']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/edit-category',['as'=>'editCategoryRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@editCategory']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/delete-file',['as'=>'deleteFileRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@deleteFile']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/move-file',['as'=>'moveFileRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@moveFile']);
            Route::post(config('cms.backendUri').'/ideaverum/intranet/email-share-file',['as'=>'emailShareRoute','uses'=>'IdeaVerum\Intranet\Controllers\Files@emailShareFile']);
        });
    }
}
