<?php

namespace domain\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use domain\entities\ArticleTag;

/**
 * ArticleTagSearch represents the model behind the search form about `domain\entities\ArticleTag`.
 */
class ArticleTagSearch extends ArticleTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleTag::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article_id' => $this->article_id,
            'tag_id' => $this->tag_id,
        ]);

        return $dataProvider;
    }
}
