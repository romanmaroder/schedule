<?php

namespace shop\controllers;

use core\readModels\User\UserReadRepository;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
       private readonly UserReadRepository $users,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'home';
        $user = $this->users->find(\Yii::$app->user->getId());
        return $this->render(
            'index',
            [
                'user' => $user
            ]
        );
    }


}
