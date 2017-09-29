<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model domain\entities\ArticleTag */

$this->title = $model->article_id;
$this->params['breadcrumbs'][] = ['label' => 'Article Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-tag-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'article_id' => $model->article_id, 'tag_id' => $model->tag_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'article_id' => $model->article_id, 'tag_id' => $model->tag_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'article_id',
            'tag_id',
        ],
    ]) ?>

</div>
