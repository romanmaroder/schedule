<?php


namespace frontend\controllers\cabinet;


use schedule\readModels\Schedule\EventReadRepository;
use schedule\readModels\User\UserReadRepository;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'cabinet';

    private $events;
    private $users;

    public function __construct($id, $module, EventReadRepository $events, UserReadRepository $users, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->events = $events;
        $this->users = $users;
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
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        $event = $this->events->getAllById($user->id);

        $provider = new ArrayDataProvider(
            [
                'allModels' => $event,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        return $this->render(
            'index',
            [
                'user' => $user,
                'provider' => $provider
            ]
        );
    }
}