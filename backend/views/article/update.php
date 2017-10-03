<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $articleForm domain\forms\article\ArticleForm */
/* @var $metaForm domain\forms\article\MetaForm */
/* @var $categoryList array */
/* @var $tagsForm domain\forms\article\TagsForm */
/* @var $tagsList array */

$this->title = 'Update Article: ' . $articleForm->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $articleForm->title, 'url' => ['view', 'id' => $articleForm->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'articleForm' => $articleForm,
        'metaForm' => $metaForm,
        'categoryList' => $categoryList,
        'tagsForm' => $tagsForm,
        'tagsList' => $tagsList
    ]) ?>

</div>
