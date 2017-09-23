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
//        echo 'here'; die;

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

    public function actionUpdate()
    {
        $categoryForm = new CategoryForm();

        if($categoryForm->load(\Yii::$app->request->post())) {
            try {
                $this->manager->update($categoryForm);
                return $this->render('view');

            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'category' => $categoryForm
        ]);
    }

    public function actionCreate()
    {
        $categoryForm = new CategoryForm();

        if($categoryForm->load(\Yii::$app->request->post())) {
            try {
                $this->manager->create($categoryForm);
                return $this->render('view');
            } catch (DomainException $exception) {
                \Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'category' => $categoryForm,
        ]);
    }

    public function actionView($id)
    {
        try {
            $category = $this->manager->getCategoryById($id);
            return $this->render('view', [
                'category' => $category,
            ]);
        } catch (DomainException $exception) {
            return \Yii::$app->session->setFlash('error', $exception->getMessage());
        }

    }
}