<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 15:54
 */

namespace IdeaVerum\Intranet\Contracts;

interface IntranetCategory{
    public function getID();
    public function getCategoryName();
    public function hasSubcategories();
    public function getSubCategories();
}
