<?php


namespace shop\widgets\Wishlist\Header;


use core\readModels\User\UserReadRepository;
use yii\base\Widget;

class WishlistWidget extends Widget
{
    public function __construct(private readonly UserReadRepository $users, public $userId = null, $config = [])
    {
        parent::__construct($config);
    }

    private function quantity(): int
    {
        if (!$user = $this->users->find($this->userId)) {
            return 0;
        }
        return $user->wishListQuantity();
    }

    public function run(): string
    {
        return $this->render(
            'quantity',
            [
                'quantity' => $this->quantity(),
            ]
        );
    }
}