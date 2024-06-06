<?php

use yii\db\Migration;

/**
 * Class m231013_184754_rename_user_table
 */
class m231013_184754_rename_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->renameTable('{{%user}}', '{{%users}}');

    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231013_184754_rename_user_table cannot be reverted.\n";

        return false;
    }
    */
}
