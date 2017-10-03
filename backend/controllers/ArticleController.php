<?php

namespace backend\controllers;

use domain\DomainException;
use domain\forms\article\ArticleForm;
use domain\forms\article\MetaForm;
use domain\forms\article\TagsForm;
use domain\managers\ArticleManager;
use domain\managers\TagManager;
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

        $this->_manager->loadTags($id);
        $tags = $this->_manager->getTagNames();


        return $this->render('view', [
            'articleForm' => $articleForm,
            'metaForm' => $metaForm,
            'tags' => implode(' ,', $tags)
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
        $tagsForm = new TagsForm();

        if ($articleForm->load(Yii::$app->request->post()) &&
            $metaForm->load(Yii::$app->request->post()) &&
            $tagsForm->load(Yii::$app->request->post())) {
            try {
                $id = $this->_manager->create($articleForm, $metaForm, $tagsForm);
                return $this->redirect(['view', 'id' => $id]);
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }

        }

        return $this->render('create', [
                'articleForm' => $articleForm,
                'metaForm' => $metaForm,
                'categoryList' => $this->_manager->getCategoryList(),
                'tagsForm' => $tagsForm,
                'tagsList' => TagManager::getTagList()
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
        $this->_manager->loadTags($id);
        $tagsForm = new TagsForm($this->_manager->getTagIds());


        if ($articleForm->load(Yii::$app->request->post()) &&
            $metaForm->load(Yii::$app->request->post()) &&
            $tagsForm->load(Yii::$app->request->post())) {

            $id = $this->_manager->update($articleForm, $metaForm, $tagsForm);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                'articleForm' => $articleForm,
                'metaForm' => $metaForm,
                'categoryList' => $this->_manager->getCategoryList(),
                'tagsForm' => $tagsForm,
                'tagsList' => TagManager::getTagList()
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
        try {
            $this->_manager->remove($id);
        } catch (DomainException $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        $this->redirect('index');
    }

}
