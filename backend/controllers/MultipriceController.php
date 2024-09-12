<?php


namespace backend\controllers;


use backend\forms\MultipriceSearch;
use core\entities\User\MultiPrice;
use core\forms\manage\User\MultiPrice\MultiPriceAddSimpleServiceForm;
use core\forms\manage\User\MultiPrice\MultiPriceCreateForm;
use core\forms\manage\User\MultiPrice\MultiPriceEditForm;
use core\forms\manage\User\MultiPrice\MultiPriceSimpleEditForm;
use core\useCases\manage\MultiPriceManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MultipriceController extends Controller
{
    private MultiPriceManageService $service;
    public function __construct($id,
        $module,
        MultiPriceManageService $service,
        $config = [])
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
        $searchModel = new MultipriceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>''
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
        $form = new MultiPriceCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $price = $this->service->create($form);
                //return $this->redirect(['view','id'=>$price->id]);
                return $this->redirect(['index']);
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
        $form = new MultiPriceEditForm($price);

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

    public function actionAdd($id)
    {
        $price= $this->findModel($id);

        $form = new MultiPriceAddSimpleServiceForm($price);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->add($price->id, $form);
                return $this->redirect(['view', 'id' => $price->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add', [
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
        if (($model = MultiPrice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}