<?php


namespace backend\controllers;


use backend\forms\PriceSearch;
use core\entities\User\Price;
use core\forms\manage\User\Price\PriceForm;
use core\useCases\manage\PriceServiceManager;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PriceController extends Controller
{
    private PriceServiceManager $service;
    public function __construct($id, $module, PriceServiceManager $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'price' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new PriceForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $price = $this->service->create($form);
                return $this->redirect(['view','id'=>$price->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $price= $this->findModel($id);
        $form = new PriceForm($price);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($price->id, $form);
                return $this->redirect(['view', 'id' => $price->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'price'=>$price,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Price::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}