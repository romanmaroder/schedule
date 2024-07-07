<?php


namespace core\forms\manage\Schedule\Additional;


use core\forms\CompositeForm;
use core\forms\manage\MetaForm;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 */
class AdditionalCreateForm extends CompositeForm
{
    public $name;
    public $description;

    public function __construct($config = [])
    {
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return [ 'meta', 'categories'];
    }

}
