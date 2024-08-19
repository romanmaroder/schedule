<?php


namespace backend\controllers;


use backend\forms\RateSearch;
use core\entities\User\Rate;
use core\forms\manage\User\Rate\RateForm;
use core\useCases\manage\RateServiceManager;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RateController extends Controller
{
    private RateServiceManager $service;
    public function __construct($id, $module, RateServiceManager $service, $config = [])
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
        $searchModel = new RateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'rate' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new RateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $rate = $this->service->create($form);
                return $this->redirect(['view','id'=>$rate->id]);
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
        $rate= $this->findModel($id);
        $form = new RateForm($rate);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($rate->id, $form);
                return $this->redirect(['view', 'id' => $rate->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'rate'=>$rate,
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
        if (($model = Rate::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}