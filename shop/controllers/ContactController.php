<?php


namespace shop\controllers;


use core\forms\ContactForm;
use core\useCases\ContactService;
use Yii;
use yii\web\Controller;

class ContactController extends Controller
{
    public function __construct($id, $module,private readonly ContactService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->send($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                return $this->goHome();
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            return $this->refresh();
        }

        return $this->render('index', ['model' => $form]);
    }
}