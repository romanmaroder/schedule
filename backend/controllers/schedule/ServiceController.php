<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\ServiceSearch;
use core\entities\Schedule\Service\Service;
use core\forms\manage\Schedule\Service\PriceForm;
use core\forms\manage\Schedule\Service\ServiceCreateForm;
use core\forms\manage\Schedule\Service\ServiceEditForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ServiceController extends Controller
{
    private $service;

    public function __construct($id, $module, \core\useCases\manage\Schedule\ServiceManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $service = $this->findModel($id);

        return $this->render(
            'view',
            [
                'service' => $service,
            ]
        );
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new ServiceCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $service = $this->service->create($form);
                return $this->redirect(['view', 'id' => $service->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'create',
            [
                'model' => $form,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $service = $this->findModel($id);

        $form = new ServiceEditForm($service);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($service->id, $form);
                return $this->redirect(['view', 'id' => $service->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'update',
            [
                'model' => $form,
                'service' => $service,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPrice($id)
    {
        $service = $this->findModel($id);

        $form = new PriceForm($service);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changePrice($service->id, $form);
                return $this->redirect(['view', 'id' => $service->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'price',
            [
                'model' => $form,
                'service' => $service,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param int $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Service
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}