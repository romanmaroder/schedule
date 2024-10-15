<?php


namespace core\forms\manage\Expenses\Expense;


use core\forms\CompositeForm;
use core\helpers\tHelper;

/**
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class ExpenseCreateForm extends CompositeForm
{
    public $name;
    public $value;
    public $status;
    public $created_at;

    public function __construct($config = [])
    {
        $this->categories = new CategoriesForm();
        $this->tags = new TagsForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['value','status'], 'integer'],
            [['created_at'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('expenses/expenses', 'Name'),
            'value' => tHelper::translate('expenses/expenses', 'Value'),
            'status' => tHelper::translate('expenses/expenses', 'Status'),
            'created_at' => tHelper::translate('app', 'Created At'),
        ];
    }

    protected function internalForms(): array
    {
        return ['categories', 'tags'];
    }

}
