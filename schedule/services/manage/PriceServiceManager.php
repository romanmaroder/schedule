<?php


namespace schedule\services\manage;


use schedule\entities\User\Price;
use schedule\forms\manage\User\Price\PriceForm;
use schedule\repositories\PriceRepository;

class PriceServiceManager
{
    private PriceRepository $repository;

    public function __construct(PriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(PriceForm $form): Price
    {
        $price = Price::create($form->name, $form->rate);
        $this->repository->save($price);
        return $price;
    }

    public function edit($id, PriceForm $form): void
    {
        $price = $this->repository->get($id);
        $price->edit($form->name,$form->rate);
        $this->repository->save($price);
    }

    public function remove($id): void
    {
        $price = $this->repository->get($id);
        $this->repository->remove($price);
    }
}