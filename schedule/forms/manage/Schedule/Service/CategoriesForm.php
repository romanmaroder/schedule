<?php


namespace schedule\forms\manage\Schedule\Service;


use schedule\entities\Schedule\Service\Service;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $other = [];

    /**
     * CategoriesForm constructor.
     * @param Service|null $service
     * @param array $config
     */
    public function __construct(Service $service = null, $config = [])
    {
        if ($service) {
            $this->main = $service->category_id;
            $this->other = ArrayHelper::getColumn($service->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['main', 'required'],
            ['main', 'integer'],
            ['other', 'each', 'rule' => ['integer']],
            ['other', 'default', 'value' => []],
        ];
    }
}