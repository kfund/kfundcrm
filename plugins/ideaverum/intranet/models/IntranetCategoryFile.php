<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 16:03
 */

namespace IdeaVerum\Intranet\Models;

use Model;

class IntranetCategoryFile extends Model implements \IdeaVerum\Intranet\Contracts\IntranetCategoryFile{

    public $table = 'ideaverum_intranet_category_files';

    public function getFilePath(){
        $category = IntranetCategory::find($this->category_id);
        $file_path = storage_path('/ideaverum/intranet').'/'.$category->getID().'/'.$this->filename;
        return $file_path;
    }

    public function getMovedDestinationFilePath($targetCategory){
        $file_path = storage_path('/ideaverum/intranet').'/'.$targetCategory.'/'.$this->filename;
        return $file_path;
    }

    public function getID()
    {
       return $this->id;
    }

    public function getFileName()
    {
        return $this->filename;
    }

    public function getCategoryId()
    {
       return $this->category_id;
    }
}
