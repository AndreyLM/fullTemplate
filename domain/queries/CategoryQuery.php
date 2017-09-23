<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 15.09.17
 * Time: 9:46
 */
namespace domain\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}