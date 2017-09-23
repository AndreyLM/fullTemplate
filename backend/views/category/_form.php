<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $cat_model domain\forms\category\CategoryForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Common</div>
        <div class="box-body">

            <?= $form->field($cat_model, 'parentId')->dropDownList($cat_model->parentCategoriesList()) ?>
            <?= $form->field($cat_model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($cat_model, 'description')->widget(CKEditor::className()) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>