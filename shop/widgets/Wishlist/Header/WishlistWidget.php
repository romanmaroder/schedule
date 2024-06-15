<?php


namespace shop\widgets\Wishlist\Header;


use core\readModels\User\UserReadRepository;
use yii\base\Widget;

class WishlistWidget extends Widget
{
    public $userId;

    private $users;

    public function __construct($userId, UserReadRepository $users, $config = [])
    {
        $this->userId = $userId;
        $this->users = $users;
        parent::__construct($config);
    }

    private function quantity(): int
    {
        $user = $this->users->find($this->userId);

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