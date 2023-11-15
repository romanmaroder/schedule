<?php

use yii\db\Migration;

/**
 * Class m231115_100707_add_schedule_product_status_field
 */
class m231115_100707_add_schedule_product_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_products}}', 'status', $this->smallInteger()->notNull());
        $this->update('{{%schedule_products}}', ['status' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%schedule_products}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231115_100707_add_schedule_product_status_field cannot be reverted.\n";

        return false;
    }
    */
}
