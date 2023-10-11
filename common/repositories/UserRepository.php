<?php


namespace common\repositories;


use common\entities\User;

class UserRepository
{
    /**
     * @param $token
     * @return User
     */
    public function getByVerificationToken($token): User
    {
        return $this->getBy(['verification_token'=>$token]);
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email):User
    {
        return $this->getBy(['email'=>$email]);
    }

    /**
     * @param $token
     * @return User
     */
    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token'=>$token]);
    }
    
    /**
     * @param string $token
     * @return bool
     */
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    /**
     * @param User $user
     */
    public function save(User $user):void
    {
        if (!$user->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param array $condition
     * @return User
     */
    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }
}