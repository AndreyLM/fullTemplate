<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 22.09.17
 * Time: 11:11
 */

namespace backend\controllers;


use domain\DomainException;
use domain\forms\category\CategoryForm;
use domain\managers\CategoryManager;
use yii\base\Module;
use yii\web\Controller;


class CategoryController extends Controller
{

    private $manager;

    public function __construct($id, Module $module, array $config = [])
    {

        $this->manager = new CategoryManager();

        parent::__construct($id, $module, $config);


    }

    public function actionIndex()
    {
        $categories = $this->manager->getSearchModel();
        $dataProvider = $categories->search(\Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $categories,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {

        $categoryForm = $this->manager->getLoadedForm($id);


        if($categoryForm->load(\Yii::$app->request->post())) {
            try {
                $id = $this->manager->update($categoryForm);
                return $this->redirect(['view', 'id' => $id]);

            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'categoryForm' => $categoryForm,
            'categoryList' => $this->manager->getCategoryArrayList()
        ]);
    }

    public function actionCreate()
    {
        $categoryForm = new CategoryForm();

        if($categoryForm->load(\Yii::$app->request->post())) {
            try {
                $id = $this->manager->create($categoryForm);
                return $this->redirect(['view' , 'id' => $id]);
            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }


        return $this->render('create', [
            'categoryForm' => $categoryForm,
            'categoryList' => $this->manager->getCategoryArrayList()
        ]);
    }

    public function actionView($id)
    {
        try {
            $categoryForm = $this->manager->getLoadedForm($id);
            return $this->render('view', [
                'categoryForm' => $categoryForm,
            ]);
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
            return $this->actionIndex();
        }

    }

    public function actionDelete($id)
    {
        try {
            $this->manager->remove($id);
        } catch (DomainException $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        $this->redirect(['index']);
    }
}