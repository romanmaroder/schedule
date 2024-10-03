<?php


namespace core\entities\Schedule\Additional;


use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;
use core\entities\Schedule\Additional\queries\AdditionalQuery;
use core\helpers\tHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property string $meta_json
 * @property int $status
 *
 * @property Meta $meta
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 */
class Additional extends ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $meta;


    public static function create($categoryId, $name, $description, Meta $meta): self
    {
        $service = new static();
        $service->category_id = $categoryId;
        $service->name = $name;
        $service->description = $description;
        $service->meta = $meta;
        $service->status = self::STATUS_DRAFT;
        $service->created_at = time();
        return $service;
    }


    public function edit($name, $description, Meta $meta): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->meta = $meta;
    }
    # Category methods

    /**
     * @param $categoryId
     */
    public function changeMainCategory($categoryId): void
    {
        $this->category_id = $categoryId;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Service is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Service is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    /**
     * @param $id
     */
    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    /**
     * @param $id
     */
    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }


    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['additional_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('schedule/additional', 'Name'),
            'category_id' => tHelper::translate('schedule/additional', 'Category Id'),
            'additional.categories' => tHelper::translate('schedule/additional', 'Other categories'),
            'status' => tHelper::translate('schedule/additional', 'Status'),
            'meta.title' => tHelper::translate('meta', 'meta.title'),
            'meta.description' => tHelper::translate('meta', 'meta.description'),
            'meta.keywords' => tHelper::translate('meta', 'meta.keywords'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_additional}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find():AdditionalQuery
    {
        return new AdditionalQuery(static::class);
    }

}