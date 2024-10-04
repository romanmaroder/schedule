<?php


namespace core\forms\manage\Shop\Product;


use core\entities\CommonUses\Characteristic;
use core\entities\Shop\Product\Value;
use yii\base\Model;

/**
 * @property int $id
 */
class ValueForm extends Model
{
    public $value;

    private $_characteristic;

    /**
     * ValueForm constructor.
     * @param Characteristic $characteristic
     * @param Value|null $value
     * @param array $config
     */
    public function __construct(Characteristic $characteristic, Value $value = null, $config = [])
    {
        if ($value) {
            $this->value = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return array_filter([
            $this->_characteristic->required ? ['value', 'required'] : false,
            $this->_characteristic->isString() ? ['value', 'string', 'max' => 255] : false,
            $this->_characteristic->isInteger() ? ['value', 'integer'] : false,
            $this->_characteristic->isFloat() ? ['value', 'number'] : false,
            ['value', 'safe'],
        ]);
    }


    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'value' => $this->_characteristic->name,
        ];
    }

    public function variantsList(): array
    {
        return $this->_characteristic->variants ? array_combine(
            $this->_characteristic->variants,
            $this->_characteristic->variants
        ) : [];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_characteristic->id;
    }
}