<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $categoryForm domain\forms\category\CategoryForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoryList array */

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Common</div>
        <div class="box-body">

            <?= $form->field($categoryForm, 'parentId')->dropDownList($categoryList) ?>
            <?= $form->field($categoryForm, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($categoryForm, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($categoryForm, 'description')->widget(CKEditor::className()) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>