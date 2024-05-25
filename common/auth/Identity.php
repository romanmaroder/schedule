<?php


namespace common\auth;


use schedule\entities\User\User;
use schedule\readModels\User\UserReadRepository;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function findIdentity($id)
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user): null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getInitials(): string
    {
        $str = $this->user->username;
        $arr = explode(' ',$str);
        foreach ($arr as $key=>$value)
        {
            mb_internal_encoding("UTF-8");
            $arr["$key"] = mb_strtoupper(mb_substr(trim($value),0,1));
        }
        return implode('.',$arr).'';
    }
    private static function getRepository(): UserReadRepository
    {
        return \Yii::$container->get(UserReadRepository::class);
    }
}