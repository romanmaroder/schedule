<?php

use core\entities\User\Employee\Employee;
use core\entities\User\User;
use yii\db\Migration;

/**
 * Class m240606_142056_create_admin_user
 */
class m240606_142056_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $admin                = new User();
        $admin->email         = 'admin@admin.ru';
        $admin->username      = 'Admin Admin';
        $admin->password      = '12345678';
        $admin->password_hash = Yii::$app->getSecurity()->generatePasswordHash($admin->password);
        $admin->phone = '+7 (999) 999-99-99';
        $admin->status        = 10;

        $admin->schedule = new \core\entities\Schedule([8,9],[6,0],4);
        $admin->schedule->hoursWork;
        $admin->schedule->weekends;
        $admin->schedule->week;

        $admin->generateAuthKey();
        $admin->save();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m240606_142056_create_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_142056_create_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
