<?php


namespace backend\controllers\shop;


use backend\forms\Shop\DeliveryMethodSearch;
use core\entities\Shop\DeliveryMethod;
use core\forms\manage\Shop\DeliveryMethodForm;
use core\useCases\manage\Shop\DeliveryMethodManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DeliveryController extends Controller
{
    public function __construct($id, $module,private readonly DeliveryMethodManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
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
        $searchModel = new DeliveryMethodSearch();
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
            'method' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DeliveryMethodForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $method = $this->service->create($form);
                return $this->redirect(['view', 'id' => $method->id]);
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
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $method = $this->findModel($id);

        $form = new DeliveryMethodForm($method);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($method->id, $form);
                return $this->redirect(['view', 'id' => $method->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'method' => $method,
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
     * @return DeliveryMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): DeliveryMethod
    {
        if (($model = DeliveryMethod::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}