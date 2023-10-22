<?php


namespace schedule\forms\manage\Schedule\Service;


use schedule\entities\Schedule\Service\Service;
use schedule\forms\manage\MetaForm;
use yii\base\Model;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
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
            $this->old = $service->old;
            $this->intern = $service->intern;
            $this->employee = $service->employee;
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