<?php

namespace backend\controllers;

use schedule\readModels\User\UserReadRepository;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private UserReadRepository $users;

    public function __construct(
        $id,
        $module,
        UserReadRepository $users,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        return $this->render(
            'index',
            [
                'user' => $user
            ]
        );
    }

}
