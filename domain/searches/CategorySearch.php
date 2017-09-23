<?php

namespace domain\searches;

use domain\entities\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategorySearch extends Model
{
    public $id;
    public $title;
    public $description;

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'title' => 'Категория',
            'description' => 'Описание',
        ];
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'description'], 'safe'],
        ];
    }
    /**
    * @param array $params
    * @return ActiveDataProvider
    */
    public function search(array $params)
    {
        $query = Category::find()->andWhere(['>', 'depth', 0]);

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                'defaultOrder' => ['lft' => SORT_ASC]
                ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}