<?php

namespace backend\controllers\schedule;

use backend\forms\Schedule\CharacteristicSearch;
use core\entities\CommonUses\Characteristic;
use core\forms\manage\Schedule\CharacteristicForm;
use core\services\manage\Schedule\CharacteristicManageService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CharacteristicController extends Controller
{
    private $service;

    public function __construct($id, $module, CharacteristicManageService $service, $config = [])
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
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharacteristicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'characteristic' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CharacteristicForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $characteristic = $this->service->create($form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $characteristic = $this->findModel($id);

        $form = new CharacteristicForm($characteristic);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($characteristic->id, $form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'characteristic' => $characteristic,
        ]);
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
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Characteristic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Characteristic
    {
        if (($model = Characteristic::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}