<?php


namespace shop\controllers\shop;


use core\entities\User\User;
use core\forms\Shop\ReviewForm;
use core\forms\Shop\AddToCartForm;
use core\readModels\Shop\BrandReadRepository;
use core\readModels\Shop\CategoryReadRepository;
use core\readModels\Shop\ProductReadRepository;
use core\readModels\Shop\TagReadRepository;
use core\readModels\User\UserReadRepository;
use core\repositories\NotFoundException;
use core\services\manage\Shop\ReviewManageService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $categories;
    private $brands;
    private $tags;
    private $users;
    private $reviews;

    public function __construct(
        $id,
        $module,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        UserReadRepository $users,
        ReviewManageService $reviews,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
        $this->users = $users;
        $this->reviews = $reviews;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            //'user' => $this->findModel(),
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

        $dataProvider = $this->products->getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            //'user' => $this->findModel(),
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
     * @return mixed
     */
    public function actionSearch()
    {
        /*$form = new SearchForm();
        $form->load(\Yii::$app->request->queryParams);
        $form->validate();

        $dataProvider = $this->products->search($form);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $form,
        ]);*/
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

        $this->layout = 'blank';

        $cartForm = new AddToCartForm($product);

        $reviewForm = new ReviewForm();

        if ($reviewForm->load(Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->reviews->add($product->id,$reviewForm);
                return $this->redirect(Yii::$app->request->referrer ?: ['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }



        return $this->render('product', [
            'product' => $product,
            'cartForm' => $cartForm,
            'reviewForm' => $reviewForm,
        ]);
    }

    protected function findModel(): User
    {
        if (($model = $this->users->find(\Yii::$app->user->id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}