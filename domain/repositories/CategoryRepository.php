<?php

namespace domain\repository;

use domain\entities\Category;
use yii\db\Exception;

class CategoryRepository
{

    public function getAll()
    {
        if(!$categories=Category::find()->all()) {
            throw new DomainException('Problem with loading ');
        }

        return $categories;
    }

    public function save()
    {

    }

    public function create($parentId, $title, $description)
    {
        $parentCategory = $this->getById($parentId);
        $newCategory = Category::create($title, $description);
        if(!$newCategory->prependTo($parentCategory)->save())
            throw new DomainException('Cannot save category');

        return true;
    }

    public function update()
    {

    }

    public function getById($id){

        if(!$category = Category::findOne($id) )
                throw new DomainException('Category doesn\'t exist');

        return $category;
    }
}