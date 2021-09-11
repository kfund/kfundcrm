<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 20.11.2019.
 * Time: 16:03
 */

namespace IdeaVerum\Intranet\Contracts;

interface IntranetCategoryFile{

    public function getID();
    public function getFileName();
    public function getCategoryId();
    public function getMovedDestinationFilePath($targetCategory);
    public function getFilePath();
}
