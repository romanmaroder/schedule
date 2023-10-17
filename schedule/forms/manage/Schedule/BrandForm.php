<?php


namespace schedule\forms\manage\Schedule;


use schedule\entities\Schedule\Brand;
use schedule\forms\manage\MetaForm;
use yii\base\Model;

/**
 * @property MetaForm $meta
 */
class BrandForm extends Model
{
    public $name;
    public $slug;

    private $_meta;
    private $_brand;

    /**
     * BrandForm constructor.
     * @param Brand|null $brand
     * @param array $config
     */
    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand){
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->_meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        }
        parent::__construct($config);
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null):bool
    {
         $self = parent::load($data, $formName);
         $meta = $this->_meta->load($data,$formName ? null : 'meta');
         return $self && $meta;

    }

    public function rules():array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => '#^[a-z0-9_-]*$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }


}