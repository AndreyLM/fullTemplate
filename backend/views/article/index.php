<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel domain\searches\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use domain\managers\ArticleManager;

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="article-index">


    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'category_id',
                'label' => 'Category',
                'filter' =>  ArticleManager::getCategoryList(),
                'value' => 'category.name',
            ],
            'tag',
            'title',
            'slug',
            [
                'attribute' => 'status',
                'label' => 'Active',
                'filter' => ['1' => 'Yes', '0' => 'No'],
                'format' => 'boolean',
            ],
            // 'short_text:ntext',
            // 'full_text:ntext',
            // 'meta_json:ntext',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
