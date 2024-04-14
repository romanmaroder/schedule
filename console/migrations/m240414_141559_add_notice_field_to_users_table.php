<?php

use yii\db\Migration;

/**
 * Class m240414_141559_add_notice_field_to_users_table
 */
class m240414_141559_add_notice_field_to_users_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}','notice',$this->string()->after('status'));
    }

    public function down()
    {
        $this->dropColumn('{{%users}}','notice');

    }
}
