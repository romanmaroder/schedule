<?php


namespace backend\controllers\shop;


use backend\forms\Shop\ReviewSearch;
use core\entities\Shop\Product\Product;
use core\forms\manage\Shop\Product\ReviewEditForm;
use core\readModels\Shop\ProductReadRepository;
use core\services\manage\Shop\ReviewManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    private $service;
    private $products;

    public function __construct(
        $id,
        $module,
        ReviewManageService $service,
        ProductReadRepository $products,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
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
        $searchModel = new ReviewSearch();
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
    public function actionView($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $review = $product->getReview($id);

        return $this->render(
            'view',
            [
                'product' => $product,
                'review' => $review,
            ]
        );
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    /*public function actionCreate()
    {
        $form = new ReviewForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $review = $this->service->add($form);
                return $this->redirect(['view', 'id' => $review->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }*/

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $review = $product->getReview($id);

        $form = new ReviewEditForm($review);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($product->id, $review->id, $form);
                return $this->redirect(['view', 'product_id' => $product->id, 'id' => $review->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'update',
            [
                'product'=>$product,
                'model' => $form,
                'review' => $review,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($product_id,$id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->service->remove($product->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionActivate($product_id,$id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->service->activate($product->id ,$id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view','product_id'=>$product_id ,'id' => $id]);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDraft($product_id,$id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->service->draft($product->id,$id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
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