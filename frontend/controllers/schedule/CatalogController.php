<?php


namespace frontend\controllers\schedule;


use schedule\readModels\Schedule\BrandReadRepository;
use schedule\readModels\Schedule\CategoryReadRepository;
use schedule\readModels\Schedule\ProductReadRepository;
use schedule\readModels\Schedule\ServiceReadRepository;
use schedule\readModels\Schedule\TagReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $service;
    private $categories;
    private $brands;
    private $tags;

    public function __construct($id,
        $module,
        ServiceReadRepository $service,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
    }

    public function actionIndex()
    {
        $dataProvider = $this->service->getAll();
        $category = $this->categories->getRoot();
        $user = \Yii::$app->user->identity;

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'user'=>$user,
        ]);
    }
    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->service->getAllByCategory($category);
        $user = \Yii::$app->user->identity;

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'user'=>$user,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBrand($id)
    {
        if (!$brand = $this->brands->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->products->getAllByBrand($brand);

        return $this->render('brand', [
            'brand' => $brand,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionTag($id)
    {
        if (!$tag = $this->tags->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->products->getAllByTag($tag);

        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionService($id)
    {
        if (!$service = $this->service->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('service', [
            'service' => $service,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProduct($id)
    {
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('product', [
            'product' => $product,
        ]);
    }
}