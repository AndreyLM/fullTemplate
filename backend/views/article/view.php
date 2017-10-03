<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $metaForm domain\forms\article\MetaForm */
/* @var $articleForm domain\forms\article\MetaForm */
/* @var $tags string */

date_default_timezone_set('Europe/Kiev');

use domain\forms\article\ArticleForm;

$this->title = $articleForm->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $articleForm->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $articleForm->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box box-default">
        <div class="box-header">
            Main article information
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $articleForm,
                'formatter' => [
                    'class'=>'yii\i18n\Formatter',
                    'dateFormat'=>'yyyy-MM-dd h:i:s',
                    'locale'=>'ru',
                    'defaultTimeZone' => 'Europe/Kiev',
                ],
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'category_name',
                        'label' => 'Category',

                    ],
                    'title',
                    'slug',
                    [
                        'attribute' => 'status',
                        'label' => 'Active',
                        'value' => function(ArticleForm $articleForm) {
                            return $articleForm->status ? 'Yes' : 'No';
                        },
                    ],
                    'created_at:date',
                    'updated_at:date',
                    'published_at:date',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            Tags
        </div>
        <div class="box-body">
            <p><?= Html::encode($tags); ?></p>
        </div>
    </div>

    <div class="box box-default">
            <div class="box-header">
                Meta information
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $metaForm,
                    'attributes' => [
                        'title',
                        'description',
                        'keywords:ntext',
                    ],
                ]) ?>
            </div>
    </div>

</div>
