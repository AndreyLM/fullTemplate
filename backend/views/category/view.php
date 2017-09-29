<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $categoryForm domain\forms\category\CategoryForm */

$this->title = $categoryForm->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $categoryForm->name;
?>
<div class="user-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $categoryForm->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $categoryForm->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Category detail view</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $categoryForm,
                'attributes' => [
                    'id',
                    'title',
                    'name',
                    'parentName'
                ],
            ]) ?>
        </div>
    </div>


    <div class="box">
        <div class="box-header with-border">Description</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($categoryForm->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
</div>