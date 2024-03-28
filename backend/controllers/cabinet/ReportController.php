<?php


namespace backend\controllers\cabinet;


use schedule\readModels\Schedule\EventReadRepository;
use schedule\services\schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    private CartService $service;
    private EventReadRepository $repository;

    public function __construct($id, $module, CartService $service, EventReadRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->repository = $repository;
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

    public function actionUnpaid()
    {
        $dataProvider = new ArrayDataProvider(
            [
                'models' => $this->repository->getUnpaidRecords()
            ]
        );

        return $this->render('unpaid',[
            'dataProvider'=>$dataProvider,
        ]);
    }

}