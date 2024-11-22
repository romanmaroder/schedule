<?php

use yii\db\Migration;

/**
 * Class m241122_134652_add_telegram_fields_to_user_table
 */
class m241122_134652_add_telegram_fields_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%users}}','t_chat_id',$this->integer()->after('id'));
        $this->addColumn('{{%users}}','t_name',$this->string()->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%users}}','t_chat_id');
        $this->dropColumn('{{%users}}','t_name');
    }

}
