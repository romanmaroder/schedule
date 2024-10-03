<?php


namespace core\forms\manage\Schedule\Service;


use core\entities\Schedule\Service\Service;
use core\forms\manage\MetaForm;
use core\forms\manage\Shop\Product\TagsForm;
use core\helpers\tHelper;
use yii\base\Model;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class PriceForm extends Model
{
    public $old;
    public $new;

    /**
     * PriceForm constructor.
     * @param Service|null $service
     * @param array $config
     */
    public function __construct(Service $service = null, $config = [])
    {
        if ($service) {
            $this->new = $service->price_new;
            $this->old = $service->price_old;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['new'], 'required'],
            [['new', 'old',], 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new' => tHelper::translate('schedule/service/price', 'Name'),
            'old' => tHelper::translate('schedule/service/price', 'Description'),
        ];
    }

}