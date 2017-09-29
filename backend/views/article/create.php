<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $articleForm domain\forms\article\ArticleForm */
/* @var $metaForm domain\forms\article\MetaForm */
/* @var $categoryList array */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'articleForm' => $articleForm,
        'metaForm' => $metaForm,
        'categoryList' => $categoryList
    ]) ?>

</div>
