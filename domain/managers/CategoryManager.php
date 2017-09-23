<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 19.09.17
 * Time: 14:03
 */
namespace domain\managers;

use domain\entities\Category;
use domain\forms\category\CategoryForm;
use domain\DomainException;
use domain\searches\CategorySearch;


class CategoryManager
{

    private $category;

    public function __construct()
    {

    }

    public function getSearchModel()
    {
        return new CategorySearch();
    }

    public function getAll()
    {
        if(!$categories = Category::find()->all()) {
            throw new DomainException('Problem with loading ');
        }

        return $categories;
    }



    public function create(CategoryForm $categoryForm)
    {
        $parentCategory = $this->getCategoryById($categoryForm->parent_id);

        $this->category = Category::create($categoryForm->title, $categoryForm->description);

        if(!$this->category->prependTo($parentCategory)->insert())
            throw new DomainException('Cannot save category');

        return true;
    }

    public function update(CategoryForm $categoryForm)
    {
        $this->category = $this->getCategoryById($categoryForm->id);
        $this->category->title = $categoryForm->title;
        $this->category->description = $categoryForm->description;

        if($categoryForm->parent_id !== $this->category->parent->id) {
            $parent = $this->getCategoryById($categoryForm->parent_id);
            $this->category->prependTo($parent);
        }

        if(!$this->category->save()) {
            throw new DomainException('Cannot update $category');
        }

        return true;
    }


    public function getCategoryById($id)
    {
        if (!$category = Category::findOne(['id'=>$id]))
            throw new DomainException('Can not find a category');
        return $category;

    }

    public function getCategoryList()
    {
        $categories = Category::find()->orderBy('lft')->asArray();
//        $cats = array_fi
//        return array_map(function(i))
    }
}