<?php


namespace common\auth;

use filsh\yii2\oauth2server\Module;
use OAuth2\Storage\UserCredentialsInterface;
use core\entities\User\User;
use core\readModels\User\UserReadRepository;
use Yii;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface, UserCredentialsInterface
{


    public function __construct(private readonly User $user)
    {
    }

    public static function findIdentity($id)
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getUsername(): string
    {
        return $this->user->username;
    }

    public function wishlistQuantity(): string
    {
        return $this->user->wishListQuantity();
    }

    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username): array
    {
        $user = self::getRepository()->findActiveByUsername($username);
        return ['user_id' => $user->id];
    }


    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }


    private static function getRepository(): UserReadRepository
    {
        return \Yii::$container->get(UserReadRepository::class);
    }

    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }
}