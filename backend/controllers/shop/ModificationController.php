<?php


namespace backend\controllers\shop;


use core\entities\Shop\Product\Product;
use core\forms\manage\Shop\Product\ModificationForm;
use core\useCases\manage\Shop\ProductManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ModificationController extends Controller
{
    public function __construct($id, $module,private readonly ProductManageService $service, $config = [])
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
        return $this->redirect('shop/product');
    }

    /**
     * @param $product_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($product_id)
    {
        $product = $this->findModel($product_id);

        $form = new ModificationForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addModification($product->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'product' => $product,
            'model' => $form,
        ]);
    }

    /**
     * @param int $product_id
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $modification = $product->getModification($id);

        $form = new ModificationForm($modification);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editModification($product->id, $modification->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'product' => $product,
            'model' => $form,
            'modification' => $modification,
        ]);
    }

    /**
     * @param $product_id
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($product_id, $id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->service->removeModification($product->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
    }

    /**
     * @param int $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}