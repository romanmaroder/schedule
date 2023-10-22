<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_related_assignments}}`.
 */
class m231022_161206_create_schedule_related_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_related_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'related_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-schedule_related_assignments}}', '{{%schedule_related_assignments}}', ['product_id', 'related_id']);

        $this->createIndex('{{%idx-schedule_related_assignments-product_id}}', '{{%schedule_related_assignments}}', 'product_id');
        $this->createIndex('{{%idx-schedule_related_assignments-related_id}}', '{{%schedule_related_assignments}}', 'related_id');

        $this->addForeignKey('{{%fk-schedule_related_assignments-product_id}}', '{{%schedule_related_assignments}}', 'product_id', '{{%schedule_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-schedule_related_assignments-related_id}}', '{{%schedule_related_assignments}}', 'related_id', '{{%schedule_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_related_assignments}}');
    }
}
