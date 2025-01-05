<?php

namespace core\entities\User;

use core\entities\AggregateRoot;
use core\entities\behaviors\ScheduleWorkBehavior;
use core\entities\Enums\UserDefaultValuesEnum;
use core\entities\Enums\UserStatusEnum;
use core\entities\EventTrait;
use core\entities\Schedule;
use core\entities\Schedule\Event\Event;
use core\entities\User\Employee\Employee;
use core\entities\User\events\UserSignUpConfirmed;
use core\entities\User\events\UserSignUpRequested;
use core\helpers\tHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 * @property string $auth_key
 * @property string $schedule_json [json]
 * @property UserStatusEnum $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password
 * @property Network[] $networks
 * @property WishlistItem[] $wishlistItems
 * @property Employee $employee
 * @property Schedule $schedule
 * @property string $notice [varchar(255)]
 * @property int $t_chat_id [int(11)]
 * @property string $t_name [varchar(255)]
 */
class User extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    public $password;
    public $schedule;


    public static function create(
        string $username,
        string $email,
        string $phone,
        #[\SensitiveParameter]
        string $password,
        Schedule $schedule,
        ?string $notice
    ): self {
        $user = new User();
        $user->username = $username;
        $user->email = $email ? $email : Yii::$app->security->generateRandomString(8) . UserDefaultValuesEnum::DEFAULT_EMAIL->value;
        $user->phone = $phone;
        $user->setPassword(!empty($password) ? $password : UserDefaultValuesEnum::DEFAULT_PASSWORD->value);
        $user->created_at = time();
        $user->status = UserStatusEnum::STATUS_ACTIVE;
        $user->schedule = $schedule;
        $user->notice = $notice;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    public function edit(
        string $username,
        string $email,
        string $phone,
        #[\SensitiveParameter] string $password,
        $status,
        Schedule $schedule,
        $notice
    ): void {
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        if (!empty($password)) {
            $this->setPassword($password);
        } else {
            $this->password_hash;
        }
        $this->status = $status;
        $this->schedule = $schedule;
        $this->notice = $notice;
        $this->updated_at = time();
    }

    public function editProfile(array $username, string $email, #[\SensitiveParameter] string $password): void
    {
        $this->username = $this->mergeFullName($username);
        $this->email = $email;
        if (!empty($password)) {
            $this->setPassword($password);
        } else {
            $this->password_hash;
        }
    }

    public function attachTelegram($tChatId, $tName): void
    {
        $this->t_chat_id = $tChatId;
        $this->t_name = $tName;
    }

    public static function requestSignup(string $username, string $email, #[\SensitiveParameter] string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->phone = '';
        $user->setPassword($password);
        $user->created_at = time();
        $user->status = $user->setUserStatus(UserStatusEnum::STATUS_INACTIVE);
        $user->verification_token = Yii::$app->security->generateRandomString();
        $user->generateAuthKey();
        $user->recordEvent(new UserSignUpRequested($user));
        return $user;
    }

    /**
     * Verify email
     *
     * @return void the saved model or null if saving fails
     */
    public function verifyEmail(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('User is already active.');
        }
        $this->status = $this->setUserStatus(UserStatusEnum::STATUS_ACTIVE);
        $this->removeEmailVerificationToken();
        $this->recordEvent(new UserSignUpConfirmed($this));
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
        $user->status = $user->setUserStatus(UserStatusEnum::STATUS_ACTIVE);
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

    public function addToWishList($productId): void
    {
        $items = $this->wishlistItems;
        foreach ($items as $item) {
            if ($item->isForProduct($productId)) {
                throw new \DomainException('Item is already added.');
            }
        }
        $items[] = WishlistItem::create($productId);
        $this->wishlistItems = $items;
    }

    public function removeFromWishList($productId): void
    {
        $items = $this->wishlistItems;
        foreach ($items as $i => $item) {
            if ($item->isForProduct($productId)) {
                unset($items[$i]);
                $this->wishlistItems = $items;
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function wishListQuantity(): int
    {
        return count($this->wishlistItems);
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
        $status,
        $schedule
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
            $schedule
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
    public function resetPassword(#[\SensitiveParameter] $password): void
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
        return $this->status == UserStatusEnum::STATUS_ACTIVE->value;
    }

    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->status == UserStatusEnum::STATUS_INACTIVE->value;
    }

    public function isChatId(): bool
    {
        return $this->t_chat_id !== null;
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

    public function getWishlistItems(): ActiveQuery
    {
        return $this->hasMany(WishlistItem::class, ['user_id' => 'id']);
    }

    public function parseFullName($fullName): array
    {
        return explode(" ", $fullName);
    }

    public function mergeFullName(array $name): string
    {
        return implode(" ", $name);
    }

    public function getInitials(): string
    {
        $str = $this->username;
        $arr = explode(' ', $str);
        foreach ($arr as $key => $value) {
            mb_internal_encoding("UTF-8");
            $arr["$key"] = mb_strtoupper(mb_substr(trim($value), 0, 1));
        }
        return implode('.', $arr) . '';
    }

    public function getHours()
    {
        return $this->schedule->hoursWork;
    }

    public function getWeekends()
    {
        return $this->schedule->weekends;
    }

    public function attributeLabels(): array
    {
        return [
            'username' => tHelper::translate('user', 'Username'),
            'email' => tHelper::translate('user', 'Email'),
            'password' => tHelper::translate('user', 'Password'),
            'phone' => tHelper::translate('user', 'Phone'),
            'status' => tHelper::translate('user', 'Status'),
            'notice' => tHelper::translate('user', 'Notice'),
            'created_at' => tHelper::translate('app', 'Created At'),
            'updated_at' => tHelper::translate('app', 'Updated At'),
            'schedule.hours' => tHelper::translate('user/schedule', 'Hours'),
            'schedule.days' => tHelper::translate('user/schedule', 'Days'),
            'schedule.week' => tHelper::translate('user/schedule', 'Week'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['networks', 'employee', 'wishlistItems'],
            ],
            ScheduleWorkBehavior::class
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): null|static
    {
        return static::findOne(['username' => $username, 'status' => UserStatusEnum::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(#[\SensitiveParameter] string $token): null|static
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                                   'password_reset_token' => $token,
                                   'status' => UserStatusEnum::STATUS_ACTIVE,
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
    public static function isPasswordResetTokenValid(#[\SensitiveParameter] string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(#[\SensitiveParameter] string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    private function setPassword(#[\SensitiveParameter] string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey(): void
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
    public function generateEmailVerificationToken(): void
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
    private function removeEmailVerificationToken(): void
    {
        $this->verification_token = null;
    }

    public function getUserStatus(): UserStatusEnum
    {

        return $this->status;
    }

    public function setUserStatus(UserStatusEnum $userStatus): User
    {
        $this->status = $userStatus;
        return $this;
    }

}