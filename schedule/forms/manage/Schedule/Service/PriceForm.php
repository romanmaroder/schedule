<?php


namespace schedule\forms\manage\Schedule\Service;


use schedule\entities\Schedule\Service\Service;
use schedule\forms\manage\MetaForm;
use schedule\forms\manage\Schedule\Product\TagsForm;
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
}