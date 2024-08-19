<?php


namespace core\useCases\manage;


use core\entities\User\Rate;
use core\forms\manage\User\Rate\RateForm;
use core\repositories\RateRepository;

class RateServiceManager
{
    private RateRepository $repository;

    public function __construct(RateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(RateForm $form): Rate
    {
        $rate = Rate::create($form->name, $form->rate);
        $this->repository->save($rate);
        return $rate;
    }

    public function edit($id, RateForm $form): void
    {
        $rate = $this->repository->get($id);
        $rate->edit($form->name,$form->rate);
        $this->repository->save($rate);
    }

    public function remove($id): void
    {
        $rate = $this->repository->get($id);
        $this->repository->remove($rate);
    }
}