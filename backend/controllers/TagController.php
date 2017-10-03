<?php

namespace backend\controllers;

use domain\forms\tag\TagForm;
use domain\managers\TagManager;
use Yii;
use domain\entities\Tag;
use domain\searches\TagSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
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

    private $_tagManager;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->_tagManager = new TagManager();
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->_tagManager->getSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param null $backUrl - url for returning if the action are called from another view
     * @return mixed
     */
    public function actionCreate($backUrl = null)
    {
        $tagForm = new TagForm();

        if ($tagForm->load(Yii::$app->request->post())) {
            $id = $this->_tagManager->save($tagForm);
            if(!$backUrl)
                return $this->redirect(['view', 'id' => $id]);
            return $this->redirect($backUrl);
        }

        return $this->render('create', [
                'tagForm' => $tagForm,
        ]);

    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $tagForm = $this->findModel($id);

        if ($tagForm->load(Yii::$app->request->post())) {
            $this->_tagManager->update($tagForm);
            return $this->redirect(['view', 'id' => $tagForm->id]);
        }

        return $this->render('update', [
                'tagForm' => $tagForm,
        ]);
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->_tagManager->remove($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return domain\forms\tag\TagForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->_tagManager->getLoadedTagForm($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }
}
