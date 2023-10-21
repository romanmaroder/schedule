<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_values}}`.
 */
class m231021_161016_create_schedule_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_values}}', [
            'product_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ],$tableOptions);

        $this->addPrimaryKey('{{%pk-schedule_values}}', '{{%schedule_values}}', ['product_id', 'characteristic_id']);

        $this->createIndex('{{%idx-schedule_values-product_id}}', '{{%schedule_values}}', 'product_id');
        $this->createIndex('{{%idx-schedule_values-characteristic_id}}', '{{%schedule_values}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-schedule_values-product_id}}', '{{%schedule_values}}', 'product_id', '{{%schedule_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-schedule_values-characteristic_id}}', '{{%schedule_values}}', 'characteristic_id', '{{%schedule_characteristics}}', 'id', 'CASCADE', 'RESTRICT');
        
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_values}}');
    }
}
