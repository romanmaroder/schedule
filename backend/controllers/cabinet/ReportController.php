<?php


namespace backend\controllers\cabinet;


use schedule\readModels\Expenses\ExpenseReadRepository;
use schedule\readModels\Schedule\EventReadRepository;
use schedule\services\schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    private CartService $service;
    private EventReadRepository $repository;
    private ExpenseReadRepository $expenses;

    public function __construct($id, $module, CartService $service, EventReadRepository $repository, ExpenseReadRepository $expenses, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->repository = $repository;
        $this->expenses = $expenses;
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
        $cart = $this->service->getCart();

        $dataProvider = new ArrayDataProvider(
            [
                'models' => $this->repository->getUnpaidRecords()
            ]
        );

        return $this->render(
            'unpaid',
            [
                'dataProvider' => $dataProvider,
                'cart' => $cart,
            ]
        );
    }

    public function actionExpenses()
    {
        $expenses = $this->expenses->getAll();
        return $this->render(
            'expenses',
            [
                'expenses' => $expenses,
            ]
        );
    }

}