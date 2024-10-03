<?php


namespace core\forms\manage\Schedule\Additional;


use core\entities\Schedule\Additional\Category;
use core\entities\Schedule\Additional\Additional;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $others = [];

    /**
     * CategoriesForm constructor.
     * @param Additional|null $service
     * @param array $config
     */
    public function __construct(Additional $service = null, $config = [])
    {
        if ($service) {
            $this->main = $service->category_id;
            $this->others = ArrayHelper::getColumn($service->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }
    public function categoriesList(): array
    {
        return ArrayHelper::map(
            Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ? str_repeat(
                            '-- ',
                            $category['depth'] - 1
                        ) . ' ' : '') . $category['name'];
            }
        );
    }
    public function rules(): array
    {
        return [
            ['main', 'required'],
            ['main', 'integer'],
            ['others', 'each', 'rule' => ['integer']],
            ['others', 'default', 'value' => []],
        ];
    }

    public function attributeLabels()
    {
        return [
            'main'=>tHelper::t('schedule/additional/category','Main'),
            'others'=>tHelper::t('schedule/additional/category','Others'),
        ];
    }
}