<?php


namespace schedule\forms\manage\Expenses\Expense;


use schedule\forms\CompositeForm;

/**
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class ExpenseCreateForm extends CompositeForm
{
    public $name;
    public $value;
    public $status;

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
        ];
    }

    protected function internalForms(): array
    {
        return ['categories', 'tags'];
    }

}
