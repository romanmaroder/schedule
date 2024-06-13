<?php


namespace shop\controllers\schedule;


use core\entities\User\User;
use core\readModels\Schedule\CategoryReadRepository;
use core\readModels\Schedule\ServiceReadRepository;
use core\readModels\Schedule\TagReadRepository;
use core\readModels\Shop\BrandReadRepository;
use core\readModels\Shop\ProductReadRepository;
use core\readModels\User\UserReadRepository;
use core\repositories\NotFoundException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PriceController extends Controller
{
    public $layout = 'price';

    private $products;
    private $service;
    private $categories;
    private $brands;
    private $tags;
    private $users;

    public function __construct(
        $id,
        $module,
        ServiceReadRepository $service,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        UserReadRepository $users,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
        $this->users = $users;
    }

    public function actionIndex()
    {
        $dataProvider = $this->service->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index',
                             [
                                 'category' => $category,
                                 'dataProvider' => $dataProvider,
                                 'user' => $this->findModel(),
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

        return $this->render(
            'category',
            [
                'category' => $category,
                'dataProvider' => $dataProvider,
                'user' => $this->findModel(),
            ]
        );
    }

    public function actionView($id)
    {
        if (!$service = $this->service->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        $category = $this->categories->find($service->category_id);
        $menu = $this->service->getAll()->getModels();

        return $this->render(
            'view',
            [
                'category' => $category,
                'menu' => $menu,
                'service' => $service,
                'user' => $this->findModel(),
            ]
        );
    }


    protected function findModel(): User
    {
        if (($model = $this->users->find(\Yii::$app->user->id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}