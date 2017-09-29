<?php

namespace backend\controllers;

use domain\DomainException;
use domain\forms\article\ArticleForm;
use domain\forms\article\MetaForm;
use domain\managers\ArticleManager;
use Yii;
use domain\entities\Article;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    private $_manager;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->_manager = new ArticleManager();
        parent::__construct($id, $module, $config);
    }

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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->_manager->getSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $this->_manager->getCategoryList()
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $articleForm = $this->_manager->getLoadedArticleForm($id);
        $metaForm = $this->_manager->getLoadedMetaForm($id);

        return $this->render('view', [
            'articleForm' => $articleForm,
            'metaForm' => $metaForm,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $articleForm = new ArticleForm();
        $metaForm = new MetaForm();

        if ($articleForm->load(Yii::$app->request->post()) &&
            $metaForm->load(Yii::$app->request->post())) {
            try {
                $id = $this->_manager->create($articleForm, $metaForm);
                return $this->redirect(['view', 'id' => $id]);
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }

        }

        return $this->render('create', [
                'articleForm' => $articleForm,
                'metaForm' => $metaForm,
                'categoryList' => $this->_manager->getCategoryList()
            ]);

    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $articleForm = $this->_manager->getLoadedArticleForm($id);
        $metaForm = $this->_manager->getLoadedMetaForm($id);

        if ($articleForm->load(Yii::$app->request->post()) &&
            $metaForm->load(Yii::$app->request->post())) {

//            echo var_dump($articleForm->published_at); die;
            $id = $this->_manager->update($articleForm, $metaForm);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                'articleForm' => $articleForm,
                'metaForm' => $metaForm,
                'categoryList' => $this->_manager->getCategoryList(),
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
