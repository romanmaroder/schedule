<?php


namespace core\useCases\manage;


use core\entities\User\MultiPrice;
use core\forms\manage\User\MultiPrice\MultiPriceAddSimpleServiceForm;
use core\forms\manage\User\MultiPrice\MultiPriceCreateForm;
use core\forms\manage\User\MultiPrice\MultiPriceEditForm;
use core\forms\manage\User\MultiPrice\MultiPriceSimpleEditForm;
use core\repositories\MultiPriceRepository;
use core\repositories\Schedule\ServiceRepository;
use core\services\TransactionManager;

class MultiPriceManageService
{
    private $prices;
    private $services;
    private $transaction;

    public function __construct(
        MultiPriceRepository $prices,
        ServiceRepository $services,
        TransactionManager $transaction,
    ) {
        $this->prices = $prices;
        $this->services = $services;
        $this->transaction = $transaction;
    }

    public function create(MultiPriceCreateForm $form): MultiPrice
    {
        $price = MultiPrice::create(
            $form->name,
            $form->rate
        );

        foreach ($form->services->lists as $listId) {
            $service = $this->services->get($listId);
            $cost = $price->cost($service->price_new);
            $price->assignService($service->id, $form->rate, $cost);
        }

        $this->transaction->wrap(
            function () use ($price, $form) {
                $this->prices->save($price);
            }
        );
        return $price;
    }

    public function edit($id, MultiPriceEditForm $form): void
    {
        $price = $this->prices->get($id);

        $price->edit(
            $form->name,
            $form->rate,
        );
        $this->transaction->wrap(
            function () use ($price, $form) {
                $price->revokeServices();
                $this->prices->save($price);

                foreach ($form->services->lists as $listId) {
                    $service = $this->services->get($listId);
                    $cost = $price->cost($service->price_new);
                    $price->assignService($service->id, $form->rate, $cost);
                }

                $this->prices->save($price);
            }
        );
    }

    public function add($id,MultiPriceAddSimpleServiceForm $form)
    {
        $price = $this->prices->get($id);

        $this->transaction->wrap(
            function () use ($price, $form) {

                foreach ($form->services->lists as $listId) {
                    $service = $this->services->get($listId);
                    $cost = $price->cost($service->price_new,$form->rate);
                    $price->assignService($service->id, $form->rate, $cost);
                }

                $this->prices->save($price);
            }
        );
    }

    public function remove($id): void
    {
        $price = $this->prices->get($id);
        $this->prices->remove($price);
    }
}