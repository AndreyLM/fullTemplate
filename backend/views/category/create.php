<?php
/* @var $this yii\web\View */
/* @var $categoryForm domain\forms\category\CategoryForm */
/* @var $categoryList array */


$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
?>

<div class="category-create">

    <?= $this->render('_form', [
        'categoryForm' => $categoryForm,
        'categoryList' => $categoryList
    ]) ?>

</div>