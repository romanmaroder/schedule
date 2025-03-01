<?php

namespace backend\controllers;

use core\readModels\Employee\EmployeeReadRepository;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function __construct($id, $module,private readonly EmployeeReadRepository $employees, $config = [])
    {
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $employees = $this->employees->findAll();


        return $this->render('index', ['employees' => $employees]);
    }

}
