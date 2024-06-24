<?php


namespace backend\controllers\schedule;


use core\readModels\Schedule\EventReadRepository;
use core\readModels\User\UserReadRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class MissingUsersController extends Controller
{
    private UserReadRepository $users;
    private EventReadRepository $events;

    public function __construct($id, $module, UserReadRepository $users, EventReadRepository $events, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->users = $users;
        $this->events = $events;
    }

    public function behaviors()
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
        $users = $this->users->findMissed($this->events->findRecordsFromTodayDate());

        return $this->render(
            'missing',
            [
                'dataProvider'=>$users
            ]
        );
    }
}