<?php

namespace backend\controllers;

use Yii;
use domain\entities\ArticleTag;
use domain\searches\ArticleTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleTagController implements the CRUD actions for ArticleTag model.
 */
class ArticleTagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArticleTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleTagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleTag model.
     * @param integer $article_id
     * @param integer $tag_id
     * @return mixed
     */
    public function actionView($article_id, $tag_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($article_id, $tag_id),
        ]);
    }

    /**
     * Creates a new ArticleTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleTag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'article_id' => $model->article_id, 'tag_id' => $model->tag_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArticleTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $article_id
     * @param integer $tag_id
     * @return mixed
     */
    public function actionUpdate($article_id, $tag_id)
    {
        $model = $this->findModel($article_id, $tag_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'article_id' => $model->article_id, 'tag_id' => $model->tag_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArticleTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $article_id
     * @param integer $tag_id
     * @return mixed
     */
    public function actionDelete($article_id, $tag_id)
    {
        $this->findModel($article_id, $tag_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArticleTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $article_id
     * @param integer $tag_id
     * @return ArticleTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($article_id, $tag_id)
    {
        if (($model = ArticleTag::findOne(['article_id' => $article_id, 'tag_id' => $tag_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
