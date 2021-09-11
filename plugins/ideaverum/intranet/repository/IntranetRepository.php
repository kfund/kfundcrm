<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 15:57
 */

namespace IdeaVerum\Intranet\Repository;

use Backend\Models\User;
use IdeaVerum\Intranet\Models\IntranetCategory as CategoryModel;
use IdeaVerum\Intranet\Contracts\IntranetCategory;
use IdeaVerum\Intranet\Contracts\IntranetCategoryFile;
use IdeaVerum\Intranet\Models\IntranetCategoryFile as FileModel;
use IdeaVerum\Intranet\Contracts\IntranetRepository as IntranetRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Mail;
use League\Flysystem\Exception;

class IntranetRepository implements IntranetRepositoryContract {

    private $file_path;
    private $active_user;
    /**
     * @var \IdeaVerum\Intranet\Models\IntranetCategory
     */
    private $category_model;
    /**
     * @var FileModel
     */
    private $file_model;

    public function __construct(CategoryModel $category_model, FileModel $file_model)
    {
        $this->category_model = $category_model;
        $this->file_model = $file_model;
        $this->file_path = storage_path('/ideaverum/intranet');
    }

    public function setActiveUser(User $user)
    {
        $this->active_user = $user;
    }

    public function getActiveUser()
    {
        return $this->active_user ?? null;
    }

    public function getCategoryById($id)
    {
        return $this->category_model->find($id);
    }

    public function saveCategory(array $data)
    {
        try{
            $category = new CategoryModel();
            $category->title = $data['title'];
            $category->parent_id = $data['parent_id'];
            $category->save();
            return ['status' => 1, 'success' => trans('ideaverum.intranet::lang.category_saved')];
        }catch (Exception $exception){
            return ['status' => 0, 'error' => $exception->getMessage()];
        }

    }

    public function deleteCategory(IntranetCategory $category)
    {
        try{
            DB::beginTransaction();

            $default_category = CategoryModel::where('is_default',true)->first();
            $this->recursiveCategoryDelete($category,$default_category);

            DB::commit();
            return ['status' => 1,'success' => trans('ideaverum.intranet::lang.category_deleted')];
        }catch (Exception $exception){
            DB::rollback();
            return ['status' => 0,'error' => $exception->getMessage()];
        }

    }

    public function editCategory(array $data)
    {
        try {
            $category = CategoryModel::find($data['category_id']);
            $category->title = $data['category_title'];
            $category->save();

            return ['status' => 1,'success' => trans('ideaverum.intranet::lang.name_successfully_changed')];
        } catch (Exception $exception){
            return ['status' => 0,'error' => $exception->getMessage()];
        }
    }

    public function getCategoryFiles(IntranetCategory $category)
    {
        $files = $this->file_model->where('category_id',$category->getID())->select("id","filename", "original_filename")->get();
        return ['status' => 1,'files' => $files,'category_name' => $category->getCategoryName()];
    }


    public function saveFiles(array $files, IntranetCategory $category, $user_id)
    {
        try{
            $file_path = $this->file_path.'/'.$category->getID();
            if(!File::isDirectory($file_path))
                File::makeDirectory($file_path);
            foreach ($files as $file){
                $original_file_name = $file->getClientOriginalName();
                $file_name = substr(md5(rand()), 0, 40);
                $extension = $file->getClientOriginalExtension();
                $file_name = $file_name .'.'.$extension;
                $file->move($file_path, $file_name);

                $intranet_file = new FileModel();
                $intranet_file->category_id = $category->getID();
                $intranet_file->author = $user_id;
                $intranet_file->filename = $file_name;
                $intranet_file->original_filename = $original_file_name;
                $intranet_file->is_deletable = true;
                $intranet_file->save();
            }
            return ['status' => 1, 'success' => trans('ideaverum.intranet::lang.file_saved')];
        }catch (Exception $exception){
            return ['status' => 0, 'error' => $exception->getMessage()];
        }
    }

    public function deleteFile(IntranetCategoryFile $file)
    {
        try{
            $filepath = $file->getFilePath();
            $file->delete();
            unlink($filepath);
            return ['status' => 1, 'success' => trans('ideaverum.intranet::lang.file_deleted')];
        }catch (Exception $exception){
            return ['status' => 0, 'error'=>$exception->getMessage()];
        }
    }

    public function moveFile($moveToCategoryId, $fileId)
    {
        try{
            $file = FileModel::find($fileId);
            $file_path = $this->file_path.'/'.$moveToCategoryId;

            if(!File::isDirectory($file_path))
                File::makeDirectory($file_path);

            Log::info("File name:".$file->filename);

            rename($file->getFilePath(), $file->getMovedDestinationFilePath($moveToCategoryId));

            $file->category_id = $moveToCategoryId;
            $file->save();

            return ['status' => 1, 'success' => trans('ideaverum.intranet::lang.file_moved')];
        }catch (Exception $exception){
            return ['status' => 0, 'error'=>$exception->getMessage()];
        }
    }

    public function getFile($file_id)
    {
        return $this->file_model->find($file_id);
    }

    public function getFileCategory(IntranetCategoryFile $file)
    {
        return $this->category_model->find($file->getCategoryId());
    }

    public function getCategoryTree($has_secure_access = false)
    {
        $categories = $this->getRootCategories($has_secure_access);
        foreach ($categories as $category)
            $this->recursiveCategories($category);
        return $categories;
    }

    public function getAllCategories($userAccess)
    {
        if($userAccess) {
            return $this->category_model->get();
        } else {
            return $this->category_model->where('is_secure', 0)->get();
        }
    }

    public function checkFileSecureCategory($file)
    {
        $category = $this->getFileCategory($file);
        if($category->is_secure)
            return true;
        return false;
    }

    public function checkIsSecureCategory($categoryId)
    {
        $category = $this->getCategoryById($categoryId);
        if($category->is_secure)
            return true;
        return false;
    }

    public function emailShareFile($file_id, $emails, $sender_email)
    {
        try{
            $file = FileModel::find($file_id);
            $file_path = $file->getFilePath();
            foreach ($emails as $email){
                Mail::send('ideaverum.intranet::mail.fileshare',['filerecepient' => $email], function ($message) use ($email,$file_path,$sender_email){
                    $message->from($sender_email);
                    $message->to($email);
                    $message->attach($file_path);
                });
            }
            return ['status' => 1, 'success' => trans('ideaverum.intranet::lang.file_sent')];
        }catch (Exception $exception){
            return ['status' => 0, 'error' => $exception->getMessage()];
        }
    }

    private function getRootCategories($has_secure_access){
        $cat = $this->category_model->where('parent_id','=',0);
        if(!$has_secure_access)
            $cat = $cat->where('is_secure',0);
        $cat = $cat->get();
        return $cat;
    }

    private function recursiveCategories(IntranetCategory $category){
        if($category->hasSubcategories()){
            $category->getSubCategories();
            foreach ($category->categories as $category_child){
                $this->recursiveCategories($category_child);
            }
        }
    }

    private function recursiveCategoryDelete(CategoryModel $category,$default_category){
        try{
            if($category->hasSubcategories()){
                $category->getSubcategories($category);
                foreach ($category->categories as $category_child){
                    $this->recursiveCategoryDelete($category_child,$default_category);
                }
            }

            // Move files to default category
            $this->_getCategoryFiles($category);

            if(!$category->files->isEmpty()){
                foreach ($category->files as $file){
                    rename( $this->file_path.'/'.$file->category_id.'/'.$file->filename,$this->file_path.'/'.$default_category->id.'/'.$file->filename);
                    $file->category_id = $default_category->id;
                    $file->save();
                }
            }
            // delete category
            $category->delete();
        }catch (\Exception $exception){
            Log::error("FILE ERROR:".$exception->getMessage());
        }
    }

    private function _getCategoryFiles(IntranetCategory $category){
        $category->files = $this->file_model->where('category_id',$category->getID())->select("id","filename",'category_id')->get();
    }
}
