<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\AdditionalSearch;
use core\entities\Schedule\Additional\Additional;
use core\forms\manage\Schedule\Additional\AdditionalCreateForm;
use core\forms\manage\Schedule\Additional\AdditionalEditForm;
use core\useCases\manage\Schedule\AdditionalManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdditionalController extends Controller
{
    private $service;

    public function __construct($id, $module, AdditionalManageService $service, $config = [])
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
        $searchModel = new AdditionalSearch();
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
        $additional = $this->findModel($id);

        return $this->render(
            'view',
            [
                'additional' => $additional,
            ]
        );
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new AdditionalCreateForm();
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
        $additional = $this->findModel($id);

        $form = new AdditionalEditForm($additional);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($additional->id, $form);
                return $this->redirect(['view', 'id' => $additional->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'update',
            [
                'model' => $form,
                'additional' => $additional,
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
     * @return Additional the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Additional
    {
        if (($model = Additional::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}