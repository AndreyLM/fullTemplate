<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.09.17
 * Time: 11:16
 */

namespace domain\forms\article;


use yii\base\Model;

class MetaForm extends Model
{
    public $title;
    public $description;
    public $keywords;

    public function rules()
    {
        return [
            [['title', 'description', 'keywords'], 'string'],

        ];
    }
    static function create($title, $description, $keywords):self {
        $metaForm = new static();

        $metaForm->title = $title;
        $metaForm->description = $description;
        $metaForm->keywords = $keywords;

        return $metaForm;
    }
}