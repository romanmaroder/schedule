<?php

use yii\db\Migration;

/**
 * Class m231024_153144_add_schedule_product_main_photo_field
 */
class m231024_153144_add_schedule_product_main_photo_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_products}}', 'main_photo_id', $this->integer());

        $this->createIndex('{{%idx-schedule_products-main_photo_id}}', '{{%schedule_products}}', 'main_photo_id');

        $this->addForeignKey('{{%fk-schedule_products-main_photo_id}}', '{{%schedule_products}}', 'main_photo_id', '{{%schedule_photos}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('{{%fk-schedule_products-main_photo_id}}', '{{%schedule_products}}');

        $this->dropColumn('{{%schedule_products}}', 'main_photo_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231024_153144_add_schedule_product_main_photo_field cannot be reverted.\n";

        return false;
    }
    */
}
