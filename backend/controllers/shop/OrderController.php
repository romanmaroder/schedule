<?php


namespace backend\controllers\shop;


use backend\forms\Shop\OrderSearch;
use core\entities\Shop\Order\Order;
use core\forms\manage\Shop\Order\OrderEditForm;
use core\useCases\manage\Shop\OrderManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    public function __construct($id, $module,private readonly OrderManageService $service, $config = [])
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
        $searchModel = new OrderSearch();
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
            'order' => $this->findModel($id),
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $order = $this->findModel($id);

        $form = new OrderEditForm($order);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($order->id, $form);
                return $this->redirect(['view', 'id' => $order->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'order' => $order,
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
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Order
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}