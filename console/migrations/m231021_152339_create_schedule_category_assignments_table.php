<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_category_assignments}}`.
 */
class m231021_152339_create_schedule_category_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_category_assignments}}', [
            'product_id'=>$this->integer()->notNull(),
            'category_id'=>$this->integer()->notNull(),
        ],$tableOptions);

        $this->addPrimaryKey('{{%pk-schedule_category_assignments}}', '{{%schedule_category_assignments}}', ['product_id', 'category_id']);

        $this->createIndex('{{%idx-schedule_category_assignments-product_id}}', '{{%schedule_category_assignments}}', 'product_id');
        $this->createIndex('{{%idx-schedule_category_assignments-category_id}}', '{{%schedule_category_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-schedule_category_assignments-product_id}}', '{{%schedule_category_assignments}}', 'product_id', '{{%schedule_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-schedule_category_assignments-category_id}}', '{{%schedule_category_assignments}}', 'category_id', '{{%schedule_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_category_assignments}}');
    }
}
