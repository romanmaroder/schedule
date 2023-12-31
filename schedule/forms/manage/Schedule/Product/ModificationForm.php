<?php


namespace schedule\forms\manage\Schedule\Product;


use schedule\entities\Schedule\Product\Modification;
use yii\base\Model;

class ModificationForm extends Model
{
    public $code;
    public $name;
    public $price;

    /**
     * ModificationForm constructor.
     * @param Modification|null $modification
     * @param array $config
     */
    public function __construct(Modification $modification = null, $config = [])
    {
        $this->code = $modification->code;
        $this->name = $modification->name;
        $this->price = $modification->price;
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