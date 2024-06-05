<?php


namespace core\forms\manage\Schedule;


use core\entities\Schedule\Brand;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\validators\SlugValidator;

/**
 * @property MetaForm $meta
 */
class BrandForm extends CompositeForm
{
    public $name;
    public $slug;

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
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        }else{
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }
}