<?php

namespace domain\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\domain\entities\Article]].
 *
 * @see \domain\entities\Article
 */
class ArticleQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return \domain\entities\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \domain\entities\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
