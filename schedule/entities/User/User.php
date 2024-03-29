<?php

namespace schedule\entities\User;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\Schedule\Event\Event;
use schedule\entities\User\Employee\Employee;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $phone
 * @property int $discount [smallint(6)]
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
// * @property string $password write-only password
 * @property string $password
 *
 * @property Network[] $networks
 * @property Employee $employee
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const DEFAULT_PASSWORD = '12345678';
    const DEFAULT_EMAIL = '@mail.com';

    public $password;


    public static function create(
        string $username,
        string $email,
        string $phone,
        string $password,
         $discount = 0
    ): self {
        $user = new User();
        $user->username = $username;
        $user->email = $email ? $email : Yii::$app->security->generateRandomString(8). self::DEFAULT_EMAIL ;
        $user->phone = $phone;
        $user->setPassword(!empty($password) ? $password : self::DEFAULT_PASSWORD);
        $user->discount = $discount;
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    public function edit(string $username, string $email, string $phone, string $password, int $discount = 0): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->discount = $discount;
        if (!empty($password)){
            $this->setPassword( $password );
        }else{
          $this->password_hash ;
        }

        $this->updated_at = time();
    }

    public static function requestSignup(string $username, string $email, string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword( $password);
        $user->created_at = time();
        $user->status = self::STATUS_INACTIVE;
        $user->generateEmailVerificationToken();
        $user->generateAuthKey();
        return $user;
    }

    /**
     * Verify email
     *
     * @return void the saved model or null if saving fails
     */
    public function verifyEmail(): void
    {
        if (!$this->isInactive()) {
            throw new \DomainException('User is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->removeEmailVerificationToken();
    }

    /**
     * @param $network
     * @param $identity
     * @return static
     * @throws \yii\base\Exception
     */
    public static function signupByNetwork($network, $identity): self
    {
        $user = new User();
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->networks = [Network::create($network, $identity)];
        return $user;
    }

    public function attachNetwork($network, $identity): void
    {
        $networks = $this->networks;
        foreach ($networks as $current) {
            if ($current->isFor($network, $identity)) {
                throw new \DomainException('Network is already attached');
            }
        }
        $networks[] = Network::create($networks, $identity);
        $this->networks = $networks;
    }

    public function attachEmployee(
        $rateId,
        $priceId,
        $firstName,
        $lastName,
        $phone,
        $birthday,
        $address,
        $color,
        $roleId,
        $status
    ): void {
        $employee[] = $this->employee;
        $employee = Employee::attach(
            $rateId,
            $priceId,
            $firstName,
            $lastName,
            $phone,
            $birthday,
            $address,
            $color,
            $roleId,
            $status,
        );
        $this->employee = $employee;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Password resetting is already requested.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Password resetting is not requested.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return ActiveQuery
     */
    public function getNetworks(): ActiveQuery
    {
        return $this->hasMany(Network::class, ['user_id' => 'id']);
    }

    public function getEmployee(): ActiveQuery
    {
        return $this->hasOne(Employee::class, ['user_id' => 'id']);
    }

    public function getMasterEvents(): ActiveQuery
    {
        return $this->hasMany(Event::class, ['master_id' => 'id']);
    }

    public function getClientEvents(): ActiveQuery
    {
        return $this->hasMany(Event::class, ['client_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    public function parseFullName($fullName)
    {
        return explode(" ", $fullName);
    }

    public function mergeFullName(array $name)
    {
        return implode(" ", $name);
    }

    public function getInitials(): string
    {
        $str = $this->username;
        $arr = explode(' ',$str);
        foreach ($arr as $key=>$value)
        {
            mb_internal_encoding("UTF-8");
            $arr["$key"] = mb_strtoupper(mb_substr(trim($value),0,1));
        }
        return implode('.',$arr).'';
    }


    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function visibleEmail($email): bool
    {
        if (!$email) {
            return false;
        }
        return true;
    }

    public function visibleDiscount($discount): bool
    {
        if (!$discount) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['networks', 'employee'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    /*public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }*/

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    private function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    /*private function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }*/

    /**
     * Generates new token for email verification
     * @throws \yii\base\Exception
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    /*private function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }*/

    /**
     * Removes email verification token
     */
    private function removeEmailVerificationToken()
    {
        $this->verification_token = null;
    }

}
