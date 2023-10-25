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
    public $intern;
    public $employee;

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
            $this->intern = $service->price_intern;
            $this->employee = $service->price_employee;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['new'], 'required'],
            [['new', 'old', 'intern', 'employee'], 'integer', 'min' => 0],
        ];
    }
}