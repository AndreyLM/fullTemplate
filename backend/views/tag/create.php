<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $tagForm domain\forms\tag\TagForm */

$this->title = 'Create Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'tagForm' => $tagForm,
    ]) ?>

</div>
