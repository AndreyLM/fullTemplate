<?php
/* @var $this yii\web\View */
/* @var $categoryForm domain\forms\category\CategoryForm */
/* @var $categoryList array */


$this->title = 'Редактировать категорию: ' . $categoryForm->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $categoryForm->name, 'url' => ['view', 'id' => $categoryForm->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'categoryForm' => $categoryForm,
        'categoryList' => $categoryList
    ]) ?>

</div>