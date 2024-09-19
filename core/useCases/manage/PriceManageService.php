<?php


namespace core\useCases\manage;


use core\entities\User\Price;
use core\forms\manage\User\Price\SimpleAddForm;
use core\forms\manage\User\Price\CreateForm;
use core\forms\manage\User\Price\EditForm;
use core\repositories\PriceRepository;
use core\repositories\Schedule\ServiceRepository;
use core\services\TransactionManager;

class PriceManageService
{
    private $prices;
    private $services;
    private $transaction;

    public function __construct(
        PriceRepository $prices,
        ServiceRepository $services,
        TransactionManager $transaction,
    ) {
        $this->prices = $prices;
        $this->services = $services;
        $this->transaction = $transaction;
    }

    public function create(CreateForm $form): Price
    {
        $price = Price::create(
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

    public function edit($id, EditForm $form): void
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

    public function add($id,SimpleAddForm $form)
    {
        $price = $this->prices->get($id);

        $this->transaction->wrap(
            function () use ($price, $form) {

                foreach ($form->services->lists as $listId) {
                    $service = $this->services->get($listId);
                    $cost = $price->cost($service->price_new,$form->rate);
                    $price->assignService($service->id, $price->checkRate($service->price_new, $form->rate), $cost);
                }

                $this->prices->save($price);
            }
        );
    }


    public function revokeService($id,$service_id)
    {
        $price = $this->prices->get($id);
        $service = $this->services->get($service_id);

        $this->transaction->wrap(
            function () use ($price, $service) {
                $price->revokeService($price->id,$service->id);
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