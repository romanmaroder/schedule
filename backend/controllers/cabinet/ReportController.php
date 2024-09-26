<?php


namespace backend\controllers\cabinet;


use backend\forms\Schedule\EventSearch;
use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Event\ServiceAssignment;
use core\readModels\Expenses\ExpenseReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\useCases\Schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    private CartService $service;
    private EventReadRepository $repository;
    private ExpenseReadRepository $expenses;

    public function __construct(
        $id,
        $module,
        CartService $service,
        EventReadRepository $repository,
        ExpenseReadRepository $expenses,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->repository = $repository;
        $this->expenses = $expenses;
    }


    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => Event::CACHE_KEY,
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $cart = $this->service->getCart();
        $events = $this->repository->getAll();
        $dataProvider = new ArrayDataProvider(
            [
                'models' => $cart->getItems(),
            ]
        );

        return $this->render(
            'index',
            [
                'cart' => $cart,
                'dataProvider' => $dataProvider,
                'events'=>$events,
            ]
        );
    }

    public function actionReport()
    {
        $cart = $this->service->getCart();



        $dataProvider = new ArrayDataProvider(
            [
                'models' => $cart->getItems(),

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

    public function actionPayment()
    {
        $card= $this->service->getCard();
        $cash= $this->service->getCash();
        $cart = $this->service->getCart();

        return $this->render(
            'method',
            [
                'card' => $card,
                'cash'=>$cash,
                'cart'=>$cart
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

    public function actionSummaryReport()
    {
        $cart = $this->service->getCart();
        $expense = $this->expenses->summ();


        return $this->render(
            'summary',
            [
                'cart' => $cart,
                'expense' => $expense
            ]
        );
    }

}