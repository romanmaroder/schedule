<?php


namespace core\forms\manage\Expenses\Expense;


use core\entities\Expenses\Expenses\Expenses;
use core\entities\Expenses\Expenses\Tag;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $newNames
 */
class TagsForm extends Model
{
    public $existing = [];
    public $textNew;

    /**
     * TagsForm constructor.
     * @param Expenses|null $service
     * @param array $config
     */
    public function __construct(Expenses $service=null, $config = [])
    {
        if ($service) {
            $this->existing = ArrayHelper::getColumn($service->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['existing', 'default', 'value' => []],
            ['textNew', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'textNew' => tHelper::translate('expenses/tag', 'Text'),
            'existing' => tHelper::translate('expenses/tag', 'Existing'),
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public function getNewNames(): array
    {
        return array_filter(array_map('trim', preg_split('#\s,\s*#i', $this->textNew)));
    }
}