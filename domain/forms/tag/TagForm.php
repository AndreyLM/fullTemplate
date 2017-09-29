<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.09.17
 * Time: 14:45
 */
namespace domain\forms\tag;


use yii\base\Model;

class TagForm extends Model
{
    public $id;
    public $name;

    public function rules() {
        return [
            ['id', 'integer'],
            ['name', 'string'],
        ];
    }
}