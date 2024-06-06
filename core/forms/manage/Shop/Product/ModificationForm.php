<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Modification;
use yii\base\Model;

class ModificationForm extends Model
{
    public $code;
    public $name;
    public $price;

    /**
     * ModificationForm constructor.
     * @param \core\entities\Shop\Product\Modification|null $modification
     * @param array $config
     */
    public function __construct(\core\entities\Shop\Product\Modification $modification = null, $config = [])
    {
        if ($modification) {
            $this->code = $modification->code;
            $this->name = $modification->name;
            $this->price = $modification->price;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['code', 'name'], 'required'],
            [['price'], 'integer'],
        ];
    }

}