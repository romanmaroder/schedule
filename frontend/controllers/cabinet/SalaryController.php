<?php


namespace frontend\controllers\cabinet;


use core\entities\Schedule\Event\Event;

use core\useCases\Schedule\CartWithParamsService;
use core\useCases\Schedule\RequestService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SalaryController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'variations' => [
                    \Yii::$app->user->getId()
                ],
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => Event::CACHE_KEY,
                ]
            ]
        ];
    }


    //public $layout = 'blank';

    public function __construct($id,
        $module,
        private readonly CartWithParamsService $serviceWithParams,
        private readonly RequestService $requestService,
        $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    public function actionIndex()
    {
        $this->serviceWithParams->setParams($this->request());
        $cart = $this->serviceWithParams->getCart();
        $dataProvider = new ArrayDataProvider([
            'models' => $cart->getItems()
                                   ]);

        return $this->render('index', [
            'cart' => $cart,
            'dataProvider'=>$dataProvider,
        ]);
    }
    private function request(): array
    {
        return $this->requestService->dataRangeParams('from_date','to_date');
    }

}