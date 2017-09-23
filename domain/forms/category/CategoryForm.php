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
    public $title;
    public $description;
    public $parent_id;


    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['parent_id', 'id'], 'integer']
        ];
    }

}