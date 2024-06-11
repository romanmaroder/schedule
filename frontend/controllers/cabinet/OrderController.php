<?php


namespace frontend\controllers\cabinet;


use core\readModels\Shop\OrderReadRepository;
use core\readModels\User\UserReadRepository;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    public $layout = 'cabinet';
    public $user;

    private $orders;
    private $users;

    public function __construct($id, $module,
        OrderReadRepository $orders,
        UserReadRepository $users,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->user = $this->users->find(\Yii::$app->user->getId());
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
        $dataProvider = $this->orders->getOwm(\Yii::$app->user->id);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$order = $this->orders->findOwn(\Yii::$app->user->id, $id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }
}