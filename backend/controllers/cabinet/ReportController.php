<?php


namespace backend\controllers\cabinet;


use schedule\entities\Expenses\Expenses\Expenses;
use schedule\entities\Schedule\Event\Event;
use schedule\readModels\Expenses\ExpenseReadRepository;
use schedule\readModels\Schedule\EventReadRepository;
use schedule\services\schedule\CartService;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
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

    public function actionSummaryReport()
    {
        $cart = $this->service->getCart();
        $expense = $this->expenses->summ();


        $even = Event::find()->select([new Expression('SUM(amount) as amount, MONTHNAME(start) as start')])
            ->groupBy(['MONTHNAME(start)'])
            ->asArray()
            ->all();

        $expen = Expenses::find()
            ->select(
                [new Expression('SUM(value) as value, MONTHNAME(FROM_UNIXTIME(created_at)) as start')]
            )->groupBy(['MONTHNAME(FROM_UNIXTIME(created_at))'])
            ->asArray()
            ->all();

        /*$b = Expenses::find()->select(
            [new Expression('SUM(value) as value, MONTHNAME(FROM_UNIXTIME(created_at)) as start')]
        )
            ->groupBy(['MONTHNAME(FROM_UNIXTIME(created_at))'])
            ->asArray()
            ->all();*/




        $event = new ArrayDataProvider(
            [
                'allModels' => $even
            ]
        );

        /*$expense = new ArrayDataProvider(
            [
                'allModels' => $expen
            ]
        )*/;


        return $this->render(
            'summary',
            [
                'cart' => $cart,
                'event' => $event,
                'expense' => $expense
            ]
        );
    }

}