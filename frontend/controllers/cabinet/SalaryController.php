<?php


namespace frontend\controllers\cabinet;


use core\useCases\Schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SalaryController extends Controller
{
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