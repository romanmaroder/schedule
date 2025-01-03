<?php


namespace backend\controllers\cabinet;


use core\entities\Schedule\Event\Event;
use core\readModels\Expenses\ExpenseReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\useCases\Schedule\CartService;
use core\useCases\Schedule\CartWithParamsService;
use JetBrains\PhpStorm\ArrayShape;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    private CartService $service;
    private CartWithParamsService $serviceWithParams;
    private EventReadRepository $repository;
    private ExpenseReadRepository $expenses;

    public function __construct(
        $id,
        $module,
        CartService $service,
        CartWithParamsService $serviceWithParams,
        EventReadRepository $repository,
        ExpenseReadRepository $expenses,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->serviceWithParams = $serviceWithParams;
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
                'variations' => [
                    \Yii::$app->user->identity->getId(),
                ],
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
        $this->serviceWithParams->setParams($this->request());
        $cart = $this->serviceWithParams->getCart();
        $amountOfExpenses = $this->expenses->getSumByDate($this->request());


        return $this->render(
            'summary',
            [
                'cart' => $cart,
                'amountOfExpenses' => $amountOfExpenses,
                'params' => $this->request(),
            ]
        );
    }

    #[ArrayShape(['from_date' => "mixed|null", 'to_date' => "mixed|null"])]
    private function request(): array
    {
        if ($request = \Yii::$app->request->post()) {
            $params = [
                'from_date' => $request['from_date'],
                'to_date' => $request['to_date']
            ];
        } else {
            $params = [
                'from_date' => null,
                'to_date' => null
            ];
        }
        return $params;
    }

}