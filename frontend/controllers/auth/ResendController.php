<?php


namespace frontend\controllers\auth;


use schedule\forms\auth\ResendVerificationEmailForm;
use schedule\services\auth\EmailResendService;
use Yii;
use yii\web\Controller;

class ResendController extends Controller
{

    private $service;

    public function __construct($id, $module, EmailResendService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $form = new ResendVerificationEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }catch(\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }
        return $this->render(
            'resendVerificationEmail',
            [
                'model' => $form
            ]
        );
    }
}