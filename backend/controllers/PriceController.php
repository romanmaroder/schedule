<?php


namespace backend\controllers;


use backend\forms\PriceSearch;
use core\entities\User\Price;
use core\forms\manage\User\Price\SimpleAddForm;
use core\forms\manage\User\Price\CreateForm;
use core\forms\manage\User\Price\EditForm;
use core\readModels\Schedule\ServiceReadRepository;
use core\useCases\manage\PriceManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PriceController extends Controller
{
    private PriceManageService $prices;
    private ServiceReadRepository $services;


    public function __construct(
        $id,
        $module,
        PriceManageService $prices,
        ServiceReadRepository $services,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->prices = $prices;
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
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model'=>''
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
                $price = $this->prices->create($form);
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
                $this->prices->edit($price->id, $form);
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
                $this->prices->add($price->id, $form);
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
            $this->prices->revokeService($id, $service_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        try {
            $this->prices->remove($id);
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