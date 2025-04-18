<?php


namespace shop\controllers\payment;


use core\entities\Shop\Order\Order;
use core\readModels\Shop\OrderReadRepository;
use core\useCases\Shop\OrderService;
use robokassa\FailAction;
use robokassa\Merchant;
use robokassa\ResultAction;
use robokassa\SuccessAction;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RobokassaController extends Controller
{
    public function __construct(
        $id,
        $module,
        public $enableCsrfValidation = false,
        private readonly OrderReadRepository $orders,
        private readonly OrderService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionInvoice($id)
    {
        $order = $this->loadModel($id);

        return $this->getMerchant()->payment($order->cost, $order->id, 'Payment', null, null);
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'result' => [
                'class' => ResultAction::class,
                'callback' => [$this, 'resultCallback'],
            ],
            'success' => [
                'class' => SuccessAction::class,
                'callback' => [$this, 'successCallback'],
            ],
            'fail' => [
                'class' => FailAction::class,
                'callback' => [$this, 'failCallback'],
            ],
        ];
    }

    public function successCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        return $this->goBack();
    }

    public function resultCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $order = $this->loadModel($nInvId);
        try {
            $this->service->pay($order->id);
            return 'OK' . $nInvId;
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function failCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $order = $this->loadModel($nInvId);
        try {
            $this->service->fail($order->id);
            return 'OK' . $nInvId;
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    private function loadModel($id): Order
    {
        if (!$order = $this->orders->findOwn(\Yii::$app->user->id, $id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $order;
    }

    private function getMerchant(): Merchant
    {
        return Yii::$app->get('robokassa');
    }
}