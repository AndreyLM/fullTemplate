<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model domain\entities\ArticleTag */

$this->title = 'Update Article Tag: ' . $model->article_id;
$this->params['breadcrumbs'][] = ['label' => 'Article Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->article_id, 'url' => ['view', 'article_id' => $model->article_id, 'tag_id' => $model->tag_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
