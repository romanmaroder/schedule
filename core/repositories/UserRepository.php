<?php


namespace core\repositories;


use core\dispatchers\EventDispatcher;
use core\entities\User\User;

class UserRepository
{

    private $dispatcher;


    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $value
     * @return User|null
     */
    public function findByUsernameOrEmail($value): ?User
    {
        return User::find()
                    ->alias('u')
            ->where(['u.username'=>$value])
                    /*->andWhere(
                        [
                            'exists',
                            Employee::find()
                                ->alias('e')
                                ->andWhere('u.id = e.user_id')
                                ->andWhere(['u.username' => $value])
                        ]
                    )*/->one();
        }

    public function findByUsername($value)
    {
        return User::find()
            ->where(['username'=>$value])
            ->one();


    }

    /**
     * @param $network
     * @param $identity
     * @return User|null
     */
    public function findByNetworkIdentity($network, $identity): ?User
    {
        return User::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }

    /**
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function clientEventCheck($id): bool
    {
        if($user = User::find()->joinWith('clientEvents ce')->andWhere(['ce.client_id'=>$id])->one()){
            throw new \RuntimeException($user->username .' have events');
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function masterEventCheck($id): bool
    {
        if($user = User::find()->joinWith('masterEvents me')->andWhere(['me.master_id'=>$id])->one()){
            throw new \RuntimeException($user->username .' have events.');
        }

        return false;
    }

    public function isAdmin($id): bool
    {
        $admin = User::find()->where(['id' => 1])->one();
        if ($admin->id == $id) {
            throw new \RuntimeException($admin->username . ' the administrator. You can\'t delete an administrator.');
        }
        return false;
    }

    /**
     * @param $token
     * @return User
     */
    public function getByVerificationToken($token): User
    {
        return $this->getBy(['verification_token' => $token]);
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    /**
     * @param $token
     * @return User
     */
    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool)User::findByPasswordResetToken($token);
    }

    /**
     * @param $productId
     * @return iterable
     */
    public function getAllByProductInWishList($productId): iterable
    {
        return User::find()
            ->alias('u')
            ->joinWith('wishlistItems w', false, 'INNER JOIN')
            ->andWhere(['w.product_id' => $productId])
            ->each();
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    /**
     * @param User $user
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(User $user):void
    {
        $this->isAdmin($user->id);

        $this->masterEventCheck($user->id);
        $this->clientEventCheck($user->id);

        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    /**
     * @param array $condition
     * @return User
     */
    private function getBy(array $condition): User
    {
        if (!$user = User::find()->where($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }
}