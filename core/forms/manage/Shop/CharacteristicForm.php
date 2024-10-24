<?php


namespace core\forms\manage\Shop;


use core\entities\CommonUses\Characteristic;
use core\helpers\CharacteristicHelper;
use core\helpers\tHelper;
use yii\base\Model;

/**
 * @property array $variants
 */
class CharacteristicForm extends Model
{

    public $name;
    public $type;
    public $required;
    public $default;
    public $textVariants;
    public $sort;

    private $_characteristic;


    public function __construct(Characteristic $characteristic = null, $config = [])
    {
        if ($characteristic) {
            $this->name = $characteristic->name;
            $this->type = $characteristic->type;
            $this->required = $characteristic->required;
            $this->default = $characteristic->default;
            $this->textVariants = implode(PHP_EOL, $characteristic->variants);
            $this->sort = $characteristic->sort;
            $this->_characteristic = $characteristic;
        } else {
            $this->sort = Characteristic::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'type', 'sort'], 'required'],
            [['required'], 'boolean'],
            [['default'], 'string', 'max' => 255],
            [['textVariants'], 'string'],
            [['sort'], 'integer'],
            [
                ['name'],
                'unique',
                'targetClass' => Characteristic::class,
                'filter' => $this->_characteristic ? ['<>', 'id', $this->_characteristic->id] : null
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/characteristic', 'name'),
            'type' => tHelper::translate('shop/characteristic', 'type'),
            'required' => tHelper::translate('shop/characteristic', 'required'),
            'default' => tHelper::translate('shop/characteristic', 'default'),
            'textVariants' => tHelper::translate('shop/characteristic', 'variants'),
            'sort' => tHelper::translate('shop/characteristic', 'sort'),
        ];
    }

    public function typesList(): array
    {
        return CharacteristicHelper::typeList();
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        //return preg_split('#\s+#i', $this->textVariants);
        return preg_split('#[\r\n]+#i', $this->textVariants);
    }
}