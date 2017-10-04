<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.10.17
 * Time: 10:57
 */

namespace domain\forms\article;


use yii\base\Model;

class TagsForm extends Model
{
    public $existing = [];

    public function __construct(array $ex = [], array $config=[])
    {
        $this->existing = $ex;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
          ['existing', 'each', 'rule' => ['integer']],
          ['existing', 'default', 'value' => []]
        ];
    }
}