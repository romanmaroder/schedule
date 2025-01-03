<?php


namespace frontend\controllers\cabinet;


use core\entities\Schedule\Event\Event;
use core\useCases\Schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SalaryController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'variations' => [
                    \Yii::$app->user->getId()
                ],
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => Event::CACHE_KEY,
                ]
            ]
        ];
    }


    //public $layout = 'blank';

    private $service;

    public function __construct($id, $module, CartService $service, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function actionIndex()
    {
        $cart = $this->service->getCart();

        $dataProvider = new ArrayDataProvider([
            'models' => $cart->getItems()
                                   ]);

        return $this->render('index', [
            'cart' => $cart,
            'dataProvider'=>$dataProvider,
        ]);
    }


}