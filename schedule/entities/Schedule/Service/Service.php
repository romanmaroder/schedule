<?php


namespace schedule\entities\Schedule\Service;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\behaviors\MetaBehavior;
use schedule\entities\Meta;
use schedule\entities\Schedule\Category;
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
 * @property int $price_intern [int(11)]
 * @property int $price_employee [int(11)]
 * @property string $meta_json
 * @property int $status
 *
 * @property Meta $meta
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property TagAssignment[] $tagAssignments
 */
class Service extends ActiveRecord
{

    public $meta;


    public static function create($categoryId,  $name, $description,Meta $meta): self
    {
        $product = new static();
        $product->category_id = $categoryId;
        $product->name = $name;
        $product->description= $description;
        $product->meta = $meta;
        $product->created_at = time();
        return $product;
    }

    /**
     * @param $new
     * @param $old
     * @param $intern
     * @param $employee
     */
    public function setPrice($new, $old, $intern, $employee): void
    {
        $this->price_new = $new;
        $this->price_old = $old;
        $this->price_intern = $intern;
        $this->price_employee = $employee;
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

    /**
     * @return ActiveQuery
     */
    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['service_id' => 'id']);
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

}