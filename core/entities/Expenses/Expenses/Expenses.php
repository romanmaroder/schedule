<?php


namespace core\entities\Expenses\Expenses;


use core\entities\Enums\PaymentOptionsEnum;
use core\entities\Enums\StatusEnum;
use core\entities\Expenses\Category;
use core\entities\Expenses\Expenses\queries\ExpensesQuery;
use core\helpers\tHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $value [int(11)]
 * @property int $category_id
 * @property StatusEnum $status
 * @property PaymentOptionsEnum $payment
 * @property int $created_at
 *
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 */
class Expenses extends ActiveRecord
{

    public static function create($categoryId, $name, $value, $status, $payment, $created_at): self
    {
        $expense = new static();
        $expense->category_id = $categoryId;
        $expense->name = $name;
        $expense->value = $value;
        $expense->status = StatusEnum::STATUS_ACTIVE;
        $expense->payment = PaymentOptionsEnum::STATUS_CASH;
        $expense->created_at = strtotime($created_at);
        return $expense;
    }


    public function edit($name, $value, $status, $payment, $created_at): void
    {
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
        $this->payment = $payment;
        $this->created_at =  strtotime($created_at);
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
            throw new \DomainException('Expense is already active.');
        }
        $this->status = StatusEnum::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Expense is already draft.');
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

    public function isCash(): bool
    {
        return $this->payment == PaymentOptionsEnum::STATUS_CASH->value;
    }

    public function isCard(): bool
    {
        return $this->payment == PaymentOptionsEnum::STATUS_CARD->value;
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
        return $this->hasMany(CategoryAssignment::class, ['expense_id' => 'id']);
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
        return $this->hasMany(TagAssignment::class, ['expense_id' => 'id']);
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

    public function attributeLabels(): array
    {
        return [
            'category_id' => tHelper::translate('expenses/expenses', 'Category'),
            'name' => tHelper::translate('expenses/expenses', 'Name'),
            'value' => tHelper::translate('expenses/expenses', 'Value'),
            'created_at' => tHelper::translate('app', 'Created At'),
            'status' => tHelper::translate('expenses/expenses', 'Status'),
            'payment' => tHelper::translate('schedule/event', 'Payment'),
            'tags.name' => tHelper::translate('expenses/tag', 'Tags'),
            'category.others' => tHelper::translate('expenses/category', 'Others'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%expenses}}';
    }

    public function behaviors(): array
    {
        return [
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

    public static function find():ExpensesQuery
    {
        return new ExpensesQuery(static::class);
    }

}