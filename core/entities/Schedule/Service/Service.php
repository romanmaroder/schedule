<?php


namespace core\entities\Schedule\Service;


use core\entities\behaviors\MetaBehavior;
use core\entities\Enums\StatusEnum;
use core\entities\Meta;
use core\entities\Schedule\Event\ServiceAssignment;
use core\entities\Schedule\Service\queries\ServiceQuery;
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
 * @property int $price_old
 * @property int $price_new
 * @property string $meta_json
 * @property StatusEnum $status
 *
 * @property Meta $meta
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 */
class Service extends ActiveRecord
{

    const CACHE_KEY = 'service';

    public $meta;


    public static function create($categoryId, $name, $description, Meta $meta): self
    {
        $service = new static();
        $service->category_id = $categoryId;
        $service->name = $name;
        $service->description = $description;
        $service->meta = $meta;
        $service->status = StatusEnum::STATUS_INACTIVE;
        $service->created_at = time();
        return $service;
    }

    /**
     * @param $new
     * @param $old
     */
    public function setPrice($new, $old): void
    {
        $this->price_new = $new;
        $this->price_old = $old;
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
        $this->status = StatusEnum::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Service is already draft.');
        }
        $this->status = StatusEnum::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status == StatusEnum::STATUS_ACTIVE->value;
    }

    public function isDraft(): bool
    {
        return $this->status == StatusEnum::STATUS_INACTIVE->value;
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

    # Tags

    public function assignTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getEvent(): ActiveQuery
    {
        return $this->hasMany(ServiceAssignment::class, ['service_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['service_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    /**
     * @return ActiveQuery
     */
    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['service_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return int
     */
    public function getPriceOld(): int
    {
        return $this->price_old;
    }

    /**
     * @return int
     */
    public function getPriceNew(): int
    {
        return $this->price_new;
    }

    public static function tableName(): string
    {
        return '{{%schedule_services}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments', 'tagAssignments'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find():ServiceQuery
    {
        return new ServiceQuery(static::class);
    }

    public function attributeLabels(): array
    {
        return [
            'category_id' => tHelper::translate('schedule/service', 'Category'),
            'created_at' => tHelper::translate('app', 'Created At'),
            'name' => tHelper::translate('schedule/service', 'Name'),
            'description' => tHelper::translate('schedule/service', 'Description'),
            'price_old' => tHelper::translate('schedule/service', 'Price old'),
            'price_new' => tHelper::translate('schedule/service', 'Price new'),
            'status' => tHelper::translate('schedule/service', 'Status'),
            'tags.name' => tHelper::translate('schedule/service/tag', 'Tags'),
            'category.others' => tHelper::translate('schedule/service/category', 'Others'),
            'meta.title' => tHelper::translate('meta', 'meta.title'),
            'meta.description' => tHelper::translate('meta', 'meta.description'),
            'meta.keywords' => tHelper::translate('meta', 'meta.keywords'),
        ];
    }

}