<?php
date_default_timezone_set('Europe/Kiev');

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $articleForm domain\forms\article\ArticleForm */
/* @var $metaForm domain\forms\article\MetaForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoryList array */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Common attributes</div>
        <div class="box-body">
            <?= $form->field($articleForm, 'category_id')->dropDownList($categoryList) ?>

            <?= $form->field($articleForm, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($articleForm, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($articleForm, 'short_text')->textarea(['rows' => 6]) ?>

            <?= $form->field($articleForm, 'full_text')->textarea(['rows' => 6]) ?>

            <?= $form->field($articleForm, 'status')->checkbox() ?>

            <?= $form->field($articleForm, 'published_at')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Meta</div>
        <div class="box-body">
            <?= $form->field($metaForm, 'title')->textInput() ?>

            <?= $form->field($metaForm, 'description')->textInput() ?>

            <?= $form->field($metaForm, 'keywords')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($articleForm->isNewRecord ? 'Create' : 'Update', ['class' => $articleForm->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
