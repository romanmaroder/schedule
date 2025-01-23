<?php


namespace core\forms\manage\Expenses\Expense;


use core\entities\Expenses\Expenses\Expenses;
use core\forms\CompositeForm;
use core\helpers\tHelper;

/**
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class ExpenseEditForm extends CompositeForm
{
    public $name;
    public $value;
    public $status;
    public $payment;
    public $created_at;

    private $_service;

    public function __construct(Expenses $service, $config = [])
    {
        $this->name = $service->name;
        $this->value = $service->value;
        $this->status = $service->status;
        $this->payment = $service->payment;
        $this->created_at = $service->created_at;
        $this->categories = new CategoriesForm($service);
        $this->tags = new TagsForm($service);

        $this->_service = $service;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [[ 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['value','status','payment'],'integer'],
            [['created_at'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('expenses/expenses', 'Name'),
            'value' => tHelper::translate('expenses/expenses', 'Value'),
            'status' => tHelper::translate('expenses/expenses', 'Status'),
            'payment' => tHelper::translate('schedule/event', 'Payment'),
            'created_at' => tHelper::translate('app', 'Created At'),
        ];
    }

    protected function internalForms(): array
    {
        return ['tags','categories'];
    }
}