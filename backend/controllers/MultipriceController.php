<?php


namespace backend\controllers;


use backend\forms\MultipriceSearch;
use core\entities\User\MultiPrice;
use core\forms\manage\User\MultiPrice\SimpleAddForm;
use core\forms\manage\User\MultiPrice\CreateForm;
use core\forms\manage\User\MultiPrice\EditForm;
use core\forms\manage\User\MultiPrice\SimpleEditForm;
use core\readModels\Schedule\ServiceReadRepository;
use core\useCases\manage\MultiPriceManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MultipriceController extends Controller
{
    private MultiPriceManageService $multiPrices;
    private ServiceReadRepository $services;


    public function __construct(
        $id,
        $module,
        MultiPriceManageService $multiPrices,
        ServiceReadRepository $services,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->multiPrices = $multiPrices;
        $this->services = $services;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'revoke' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new MultipriceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'price' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new CreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $price = $this->multiPrices->create($form);
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
        $form = new EditForm($price);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->multiPrices->edit($price->id, $form);
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
        $price = $this->findModel($id);

        $form = new SimpleAddForm($price);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->multiPrices->add($price->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render(
            'add',
            [
                'model' => $form,
                'price' => $price,
            ]
        );
    }


    public function actionRevoke($id, $service_id)
    {
        try {
            $this->multiPrices->revokeService($id, $service_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        try {
            $this->multiPrices->remove($id);
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