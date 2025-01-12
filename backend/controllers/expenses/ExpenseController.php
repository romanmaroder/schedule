<?php


namespace backend\controllers\expenses;


use backend\forms\Expenses\ExpenseSearch;
use core\entities\Expenses\Expenses\Expenses;
use core\forms\manage\Expenses\Expense\ExpenseCreateForm;
use core\forms\manage\Expenses\Expense\ExpenseEditForm;
use core\useCases\manage\Expenses\ExpenseManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExpenseController extends Controller
{
    public function __construct($id, $module,private readonly ExpenseManageService $expense, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $expense = $this->findModel($id);

        return $this->render(
            'view',
            [
                'expense' => $expense,
            ]
        );
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new ExpenseCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $expense = $this->expense->create($form);
                return $this->redirect(['view', 'id' => $expense->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'create',
            [
                'model' => $form,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $expense = $this->findModel($id);

        $form = new ExpenseEditForm($expense);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->expense->edit($expense->id, $form);
                return $this->redirect(['view', 'id' => $expense->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'update',
            [
                'model' => $form,
                'expense' => $expense,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->expense->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->expense->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->expense->draft($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param int $id
     * @return Expenses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Expenses
    {
        if (($model = Expenses::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}