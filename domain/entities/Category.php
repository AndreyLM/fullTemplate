<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 14.09.17
 * Time: 20:27
 */

namespace domain\entities;


use yii\db\ActiveRecord;
use domain\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;

class Category extends ActiveRecord
{
    /**
     * @property integer $id
     * @property string $title
     * @property string $description
     * @property integer $lft
     * @property integer $rgt
     * @property integer $depth

     *
     * @property Category $parent
     * @property Category[] $parents
     * @property Category[] $children
     * @property Category $prev
     * @property Category $next
     * @mixin NestedSetsBehavior
     */


    static function tableName ()
    {
        return '{{%category}}';
    }

    static function create($title, $description) : Category
    {
        $category = new static();

        $category->title = $title;
        $category->description = $description;

        return $category;
    }

    public function edit($title, $description, $parentId) {
        $this->title = $title;
        $this->description = $description;
    }

    public function behaviors()
    {
        return [
            NestedSetsBehavior::className(),
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(static::className());
    }

}