<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 19.09.17
 * Time: 14:07
 */

namespace domain\forms\category;

use yii\base\Model;

class CategoryForm extends Model
{

    public $id;
    public $name;
    public $title;
    public $description;
    public $parentId;
    public $parentName;


    public function rules()
    {
        return [
            [['name', 'title', 'description'], 'required'],
            [['title', 'description', 'parentName'], 'string'],
            [['parentId', 'id'], 'integer']
        ];
    }

}