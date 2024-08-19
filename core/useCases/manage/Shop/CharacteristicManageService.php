<?php


namespace core\useCases\manage\Shop;


use core\entities\CommonUses\Characteristic;
use core\forms\manage\Shop\CharacteristicForm;
use core\repositories\Shop\CharacteristicRepository;

class CharacteristicManageService
{
    private $characteristics;

    public function __construct(CharacteristicRepository $characteristics)
    {
        $this->characteristics = $characteristics;
    }

    /**
     * @param CharacteristicForm $form
     * @return Characteristic
     */
    public function create(CharacteristicForm $form): Characteristic
    {
        $characteristic = Characteristic::create(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristics->save($characteristic);
        return $characteristic;
    }

    /**
     * @param $id
     * @param CharacteristicForm $form
     */
    public function edit($id, CharacteristicForm $form): void
    {
        $characteristic = $this->characteristics->get($id);
        $characteristic->edit(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort,
        );
        $this->characteristics->save($characteristic);
    }

    /**
     * @param $id
     */
    public function remove($id): void
    {
        $characteristic = $this->characteristics->get($id);
        $this->characteristics->remove($characteristic);
    }
}