<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 14:27
 */

namespace IdeaVerum\Intranet\Controllers;

use Flash;
use Backend\Facades\BackendMenu;
use Backend\Classes\Controller;
use IdeaVerum\Intranet\Contracts\IntranetRepository;
use Illuminate\Http\Request;
use Backend\Facades\BackendAuth;
use Intervention\Image\ImageManagerStatic as Image;


class Files extends Controller{

    public $requiredPermissions = ['ideaverum.intranet.access_intranet'];
    /**
     * @var IntranetRepository
     */
    private $intranetRepository;

    public function __construct(IntranetRepository $intranetRepository)
    {
        parent::__construct();
        $this->pageTitle = "Intranet";
        BackendMenu::setContext('IdeaVerum.Intranet','intranet');
        $this->intranetRepository = $intranetRepository;
        $this->addCss("/plugins/ideaverum/intranet/assets/css/main.css");
        $this->addCss("/plugins/ideaverum/intranet/assets/css/dropzone.css");
        $this->addJs("/plugins/ideaverum/intranet/assets/js/vue.js");
    }

    public function index(){
        $categories = $this->getCategoryTree();
        $userAccessToSecureCategory = $this->checkUserAccess();
        $categoryList = $this->intranetRepository->getAllCategories($userAccessToSecureCategory);
        $this->vars['categories'] = $categories;
        $this->vars['saveFileRoute'] = route('saveFileRoute');
        $this->vars['getFilesRoute'] = route('getFilesRoute');
        $this->vars['readFileRoute'] = route('readFileRoute');
        $this->vars['saveCategoryRoute'] = route('saveCategoryRoute');
        $this->vars['deleteRoute'] = route('deleteCategoryRoute');
        $this->vars['editRoute'] = route('editCategoryRoute');
        $this->vars['deleteFileRoute'] = route('deleteFileRoute');
        $this->vars['moveFileRoute'] = route('moveFileRoute');
        $this->vars['emailShareRoute'] = route('emailShareRoute');
        $this->vars['category_list'] = $categoryList;

        $this->addJs("/plugins/ideaverum/intranet/assets/js/datatables.js");
        $this->addJs("/plugins/ideaverum/intranet/assets/js/intranet.js");
        $this->addCss("/plugins/ideaverum/intranet/assets/css/datatables.bootstrap4.min.css");
    }

    public function saveFile(Request $request){
        $user = BackendAuth::getUser();
        $category_id = $request->category_id;
        $files = $request->files->all()['file'];
        $user_id = $user->id;
        $response = $this->intranetRepository->saveFiles($files,$this->intranetRepository->getCategoryById($category_id),$user_id);
        return response()->json($response);
    }

    public function getFiles(Request $request){
        $category_id = $request->category_id;
        $files = $this->intranetRepository->getCategoryFiles($this->intranetRepository->getCategoryById($category_id));
        return $files;
    }

    public function readFile($file_id){
        $user = BackendAuth::getUser();
        $file = $this->intranetRepository->getFile($file_id);
        if($this->intranetRepository->checkFileSecureCategory($file)){

            if(!$user->hasAccess('ideaverum.intranet.secure_category'))
                return redirect()->back();
        }
        $file_ext = pathinfo($file->getFilepath())['extension'];

        switch ($file_ext){
            case IntranetRepository::FILE_TYPE_JPEG:
            case strtoupper(IntranetRepository::FILE_TYPE_JPEG):
            case IntranetRepository::FILE_TYPE_JPG:
            case strtoupper(IntranetRepository::FILE_TYPE_JPG):
            case IntranetRepository::FILE_TYPE_PNG:
            case strtoupper(IntranetRepository::FILE_TYPE_PNG):
                return Image::make($file->getFilepath())->response();
                break;
            case IntranetRepository::FILE_TYPE_PDF:
                return response()->file($file->getFilepath(), ['Content-Disposition' => 'inline; filename="'.$file->filename.'"',
                    'Content-Type' => 'application/pdf']);
                break;
            default:
                return response()->download($file->getFilepath());
                break;
        }
    }

    public function saveCategory(Request $request){
        $category_title = $request->category_title;
        $category_parent = $request->selected_category;

        $response = $this->intranetRepository->saveCategory(['title' => $category_title,'parent_id' => $category_parent]);
        return response()->json($response);
    }

    public function deleteCategory(Request $request){
        $category_id = $request->category_id;

        $response = $this->intranetRepository->deleteCategory($this->intranetRepository->getCategoryById($category_id));
        return response()->json($response);
    }

    public function editCategory(Request $request){

        $category_id = $request->category_id;
        $category_title = $request->category_title;

        $response = $this->intranetRepository->editCategory(['category_id' => $category_id, 'category_title' => $category_title]);
        return response()->json($response);
    }

    public function deleteFile(Request $request){
        $file_id = $request->file_id;

        $response = $this->intranetRepository->deleteFile($this->intranetRepository->getFile($file_id));

        return response()->json($response);
    }

    public function moveFile(Request $request){
        $fileId = $request->id;
        $moveToCategoryId = $request->selected_category;

        $user = BackendAuth::getUser();
        if($this->intranetRepository->checkIsSecureCategory($moveToCategoryId)){
            if(!$user->hasAccess('ideaverum.intranet.secure_category'))
                return response()->json(['status'=>0, 'error'=> trans('ideaverum.intranet::lang.you_have_no_authority')]);
        }

        $response = $this->intranetRepository->moveFile($moveToCategoryId, $fileId);
        return response()->json($response);
    }

    public function emailShareFile(Request $request){
        $file_id = $request->file_id;
        $emails = $request->recepient_emails;
        $sender_email = BackendAuth::getUser()->email;
        if($emails != ""){
            $emails = explode(',',str_replace(' ', '', $emails));
            $this->intranetRepository->emailShareFile($file_id, $emails,$sender_email);
        }
        
        
    }
    
    private function getCategoryTree(){
        $has_secure_category_access = false;
        if($this->user->hasAccess('ideaverum.intranet.secure_category'))
            $has_secure_category_access = true;
        return $this->intranetRepository->getCategoryTree($has_secure_category_access);
    }

    public function checkUserAccess(){
        $user = BackendAuth::getUser();
        if(!$user->hasAccess('ideaverum.intranet.secure_category')) {
            $access = false;
        } else {
            $access = true;
        }
        return $access;
    }

}
