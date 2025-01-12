<?php


namespace shop\controllers\auth;


use core\forms\auth\ResendVerificationEmailForm;
use core\useCases\auth\EmailResendService;
use Yii;
use yii\web\Controller;

class ResendController extends Controller
{

    public $layout='main-login';

    public function __construct($id, $module,private readonly EmailResendService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
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