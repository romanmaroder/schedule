<?php


namespace backend\controllers\cabinet;


use schedule\services\schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    private $service;

    public function __construct($id, $module, CartService $service, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function actionIndex()
    {
        $cart = $this->service->getCart();

        $dataProvider = new ArrayDataProvider(
            [
                'models' => $cart->getItems()
            ]
        );


        return $this->render(
            'index',
            [
                'cart' => $cart,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionReport()
    {
        $cart = $this->service->getCart();


        $dataProvider = new ArrayDataProvider(
            [
                'models' => $cart->getItems()
            ]
        );
        return $this->render(
            'report',
            [
                'cart' => $cart,
                'dataProvider' => $dataProvider,
            ]
        );
    }

}