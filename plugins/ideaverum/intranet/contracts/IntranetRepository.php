<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 15:57
 */

namespace IdeaVerum\Intranet\Contracts;

use Backend\Models\User;

interface IntranetRepository{

    const FILE_TYPE_PDF = "pdf";
    const FILE_TYPE_JPG = "jpg";
    const FILE_TYPE_JPEG = "jpeg";
    const FILE_TYPE_PNG = "png";

    public function setActiveUser(User $user);
    public function getActiveUser();
    public function getAllCategories($userAccess);
    public function getCategoryById($id);
    public function saveCategory(array $data);
    public function deleteCategory(IntranetCategory $category);
    public function getCategoryFiles(IntranetCategory $category);
    public function saveFiles(array $files, IntranetCategory $category, $user_id);
    public function deleteFile(IntranetCategoryFile $file);
    public function getFile($file_id);
    public function getFileCategory(IntranetCategoryFile $file);
    public function getCategoryTree($has_secure_access);
    public function checkFileSecureCategory($file);
    public function checkIsSecureCategory($categoryId);
    public function emailShareFile($file_id, $emails, $sender_email);
}
