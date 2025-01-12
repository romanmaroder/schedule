<?php


namespace shop\controllers\shop;


use common\auth\Identity;
use core\cart\shop\Cart;
use core\forms\Shop\Order\OrderForm;
use core\readModels\User\UserReadRepository;
use core\useCases\Shop\OrderService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class CheckoutController extends Controller
{
    public $layout = 'blank';
    public $user;

    public function __construct(
        $id,
        $module,
        private readonly OrderService $service,
        private readonly Cart $cart,
        private readonly UserReadRepository $users,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->user->isGuest) {
            $this->user = $this->users->find(Yii::$app->user->getId());
        }
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new OrderForm($this->cart->getWeight());

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $order = $this->service->checkout(Yii::$app->user->id, $form);
                return $this->redirect(['/cabinet/order/view', 'id' => $order->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'cart' => $this->cart,
            'model' => $form,
            'user' => $this->user,
        ]);
    }
}