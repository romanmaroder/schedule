<?php


namespace backend\controllers\cabinet;


use schedule\services\schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SalaryController extends Controller
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

        /* echo'<pre>';
         var_dump($cart->getItems());
         die();*/
        $dataProvider = new ArrayDataProvider([
                                                  'models' => $cart->getItems()
                                              ]);



        return $this->render('index', [
            'cart' => $cart,
            'dataProvider'=>$dataProvider,
        ]);
    }

}