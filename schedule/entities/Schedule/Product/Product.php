<?php


namespace schedule\entities\Schedule\Product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\behaviors\MetaBehavior;
use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;
use schedule\entities\Schedule\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property int $created_at
 * @property string $code
 * @property string $name
 * @property int $category_id
 * @property int $brand_id
 * @property int $price_old
 * @property int $price_new
 * @property int $price_intern [int(11)]
 * @property int $price_employee [int(11)]
 * @property int $rating
 * @property string $meta_json
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property TagAssignment[] $tagAssignments
 * @property RelatedAssignment[] $relatedAssignments
 * @property Modification[] $modifications
 * @property Value[] $values
 * @property Photo[] $photos
 */
class Product extends ActiveRecord
{

    public $meta;


    public static function create($brandId, $categoryId, $code, $name, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
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

    public function edit($brandId, $code, $name, Meta $meta): void
    {
        $this->brand_id = $brandId;
        $this->code = $code;
        $this->name = $name;
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

    /**
     * @param array $photos
     */
    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
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
    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['product_id' => 'id']);
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
                'relations' => ['categoryAssignments', 'values'],
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