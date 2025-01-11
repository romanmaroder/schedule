<?php


namespace backend\controllers\cabinet;


use core\readModels\Expenses\ExpenseReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\useCases\Schedule\CartService;
use core\useCases\Schedule\CartWithParamsService;
use core\useCases\Schedule\RequestService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly CartService $service,
        private readonly CartWithParamsService $serviceWithParams,
        private readonly EventReadRepository $repository,
        private readonly ExpenseReadRepository $expenses,
        private readonly RequestService $requestService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }


    /*public function behaviors()
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
    }*/

    public function actionIndex()
    {
        $this->serviceWithParams->setParams($this->request());
        $cart = $this->serviceWithParams->getCart();

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
                'events' => $events,
            ]
        );
    }

    public function actionReport()
    {
        $this->serviceWithParams->setParams($this->request());
        $cart = $this->serviceWithParams->getCart();

        $dataProvider = new ArrayDataProvider(
            [
                'allModels' => $cart->getItems(),
                'pagination' => false
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
        $card = $this->service->getCard();
        $cash = $this->service->getCash();
        $cart = $this->service->getCart();

        return $this->render(
            'method',
            [
                'card' => $card,
                'cash' => $cash,
                'cart' => $cart
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

    private function request(): array
    {
        return $this->requestService->dataRangeParams('from_date', 'to_date');
    }

}