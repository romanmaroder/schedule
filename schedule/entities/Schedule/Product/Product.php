<?php


namespace schedule\entities\Schedule\Product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\behaviors\MetaBehavior;
use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;
use schedule\entities\Schedule\Category;
use schedule\entities\Schedule\Tag;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property int $created_at
 * @property string $code
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property int $brand_id
 * @property int $price_old
 * @property int $price_new
 * @property int $price_intern [int(11)]
 * @property int $price_employee [int(11)]
 * @property int $rating
 * @property int $main_photo_id
 * @property string $meta_json
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property Category $category
 * @property Category[] $categories
 * @property CategoryAssignment[] $categoryAssignments
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property RelatedAssignment[] $relatedAssignments
 * @property Modification[] $modifications
 * @property Value[] $values
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 * @property Review[] $reviews
 */
class Product extends ActiveRecord
{

    public $meta;


    public static function create($brandId, $categoryId, $code, $name,$description, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->description = $description;
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

    public function edit($brandId, $code, $name,$description, Meta $meta): void
    {
        $this->brand_id = $brandId;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->meta = $meta;
    }

    # Value methods

    /**
     * @param $id
     * @param $value
     */
    public function setValue($id, $value): void
    {
        $values = $this->values;
        foreach ($values as $value) {
            if ($value->isForCharacteristic($id)) {
                $value->change($value);
                $this->values = $values;
            }
            return;
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    /**
     * @param $id
     * @return Value
     */
    public function getValue($id): Value
    {
        $values = $this->values;
        foreach ($values as $value) {
            if ($value->isForCharacteristic($id)) {
                return $value;
            }
        }
        return Value::blank($id);
    }

    # Modification

    public function getModification($id): Modification
    {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function addModification($code, $name, $price): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification) {
            if ($modification->isCodeEqualTo($code)) {
                throw new \DomainException('Modification already exists.');
            }
        }
        $modifications[] = Modification::create($code, $name, $price);
        $this->modifications = $modifications;
    }

    public function editModification($id, $code, $name, $price): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                $modification->edit($code, $name, $price);
                $this->modifications = $modifications;
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function removeModification($id): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                unset($modifications[$i]);
                $this->modifications = $modifications;
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
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

    # Photo methods

    /**
     * @param UploadedFile $file
     */
    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    /**
     * @param $id
     */
    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    /**
     * @param array $photos
     */
    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    # Related products

    public function assignRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForProduct($id)) {
                return;
            }
        }
        $assignments[] = RelatedAssignment::create($id);
        $this->relatedAssignments = $assignments;
    }

    public function revokeRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForProduct($id)) {
                unset($assignments[$i]);
                $this->relatedAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }


    # Reviews

    public function addReview($userId, $vote, $text): void
    {
        $reviews = $this->reviews;
        $reviews[] = Review::create($userId, $vote, $text);
        $this->updateReviews($reviews);
    }

    public function editReview($id, $vote, $text): void
    {
        $this->doWithReview(
            $id,
            function (Review $review) use ($vote, $text) {
                $review->edit($vote, $text);
            }
        );
    }

    public function activateReview($id): void
    {
        $this->doWithReview(
            $id,
            function (Review $review) {
                $review->activate();
            }
        );
    }

    public function draftReview($id): void
    {
        $this->doWithReview(
            $id,
            function (Review $review) {
                $review->draft();
            }
        );
    }

    private function doWithReview($id, callable $callback): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $callback($review);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    private function updateReviews(array $reviews): void
    {
        $amount = 0;
        $total = 0;

        foreach ($reviews as $review) {
            if ($review->isActive()) {
                $amount++;
                $total += $review->getRating();
            }
        }

        $this->reviews = $reviews;
        $this->rating = $amount ? $total / $amount : null;
    }


    /**
     * @return ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
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
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
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
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    /**
     * @return ActiveQuery
     */
    public function getModifications(): ActiveQuery
    {
        return $this->hasMany(Modification::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRelateds(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'related_id'])->via('relatedAssignments');
    }

    /**
     * @return ActiveQuery
     */
    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return ActiveQuery
     */
    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRelatedAssignments(): ActiveQuery
    {
        return $this->hasMany(RelatedAssignment::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_products}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'categoryAssignments',
                    'tagAssignments',
                    'relatedAssignments',
                    'modifications',
                    'values',
                    'photos',
                    'reviews'
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes):void
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

}