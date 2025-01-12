<?php


namespace shop\controllers;


use core\readModels\PageReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function __construct($id, $module,private readonly PageReadRepository $pages, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @internal param string $slug
     */
    public function actionView($id)
    {
        if (!$page = $this->pages->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'page' => $page,
        ]);
    }
}