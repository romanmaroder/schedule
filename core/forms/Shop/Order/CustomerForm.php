<?php


namespace core\forms\Shop\Order;


use yii\base\Model;

class CustomerForm extends Model
{
    public $phone;
    public $name;
    public $first_name;
    public $last_name;

    public function fullName():string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function rules(): array
    {
        return [
            [['phone', 'first_name','last_name'], 'required'],
            [['phone', 'name'], 'string', 'max' => 255],
            [['name'],'safe']
        ];
    }
}