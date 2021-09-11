<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 15:53
 */
namespace IdeaVerum\Intranet\Models;
use Model;

class IntranetCategory extends Model implements \IdeaVerum\Intranet\Contracts\IntranetCategory {

    public $table = 'ideaverum_intranet_categories';

    public function getID()
    {
        return $this->id;
    }

    public function getCategoryName()
    {
        return $this->title;
    }

    public function hasSubcategories()
    {
        if(IntranetCategory::where('parent_id',$this->getID())->count() > 0)
            return true;
        return false;
    }

    public function getSubCategories()
    {
        $this->categories = IntranetCategory::where('parent_id',$this->getID())->get();
    }
}
