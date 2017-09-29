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
use yii\base\Exception;
use yii\helpers\ArrayHelper;


class CategoryManager
{

    public function __construct()
    {

    }

    public function getSearchModel():CategorySearch
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

    public function getLoadedForm($id):CategoryForm
    {
        $categoryForm = new CategoryForm();

        if(!$id) {
            return $categoryForm;
        }

        $category = $this->getCategoryById($id);

        $categoryForm->id = $category->id;
        $categoryForm->name = $category->name;
        $categoryForm->title = $category->title;
        $categoryForm->description = $category->description;
        $categoryForm->parentId = $category->parent->id;
        $categoryForm->parentName = $category->parent->name;

        return $categoryForm;

    }

    public function remove($id) {

        $category = $this->getCategoryById($id);
        if($category->isRoot()) {
            throw new DomainException('First remove all children categories');
        }

        try {
            $category->delete();
        } catch (Exception $exception) {
            throw new DomainException('Some issue with removing category');
        }
    }

    public function create(CategoryForm $categoryForm):int
    {

        try {
            $parentCategory = $this->getCategoryById($categoryForm->parentId);
            $category = Category::create($categoryForm->name, $categoryForm->title, $categoryForm->description);
            $category->prependTo($parentCategory)->insert();
        } catch (Exception $exception) {
            throw new DomainException('Cannot save category: '.$exception->getMessage());
        }

        return $category->id;
    }

    public function update(CategoryForm $categoryForm):int
    {

        try {
            $category = $this->getCategoryById($categoryForm->id);

            $category->name = $categoryForm->name;
            $category->title = $categoryForm->title;
            $category->description = $categoryForm->description;
            if((integer)$categoryForm->parentId !== $category->parent->id) {
                $parent = $this->getCategoryById($categoryForm->parentId);
                $category->prependTo($parent);
                $category->save();
            }
        } catch (Exception $exception) {
            throw new DomainException('Problem with updating category: '. $exception);
        }

        return $category->id;
    }


    public function getCategoryById($id):Category
    {
        if (!$category = Category::findOne(['id'=>$id]))
            throw new DomainException('Can not find a category');
        return $category;

    }

    static function getCategoryArrayList():array
    {
        $categories = Category::find()->orderBy('lft')->all();

        return ArrayHelper::map($categories, 'id', function(Category $category){
            return str_repeat('--', $category->depth).' '.$category->name;
        });
    }
}