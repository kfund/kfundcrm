<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 21.11.2019.
 * Time: 14:25
 */

namespace  IdeaVerum\Crm\Updates;

use IdeaVerum\Intranet\Models\IntranetCategory;
use Seeder;
class Seed_1_0_0 extends Seeder{

    public function run()
    {
        $this->createDefaultCategory();
        $this->createSecureCategory();
    }

    private function createDefaultCategory(){
        $category = new IntranetCategory();
        $category->title = trans('ideaverum.intranet::lang.default_category');
        $category->parent_id = 0;
        $category->owner = 0;
        $category->is_default = 1;
        $category->save();
    }

    private function createSecureCategory(){
        $category = new IntranetCategory();
        $category->title = trans('ideaverum.intranet::lang.secure');
        $category->parent_id = 0;
        $category->is_secure = 1;
        $category->owner = 0;
        $category->is_default = 0;
        $category->save();
    }
}
