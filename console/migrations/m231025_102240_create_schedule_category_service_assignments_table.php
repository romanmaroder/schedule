<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_category_service_assignments}}`.
 */
class m231025_102240_create_schedule_category_service_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_category_service_assignments}}', [
            'service_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-schedule_category_service_assignments}}', '{{%schedule_category_service_assignments}}', [ 'service_id', 'category_id']);

        $this->createIndex('{{%idx-schedule_category_service_assignments-service_id}}', '{{%schedule_category_service_assignments}}', 'service_id');
        $this->createIndex('{{%idx-schedule_category_service_assignments-category_id}}', '{{%schedule_category_service_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-schedule_category_service_assignments-service_id}}', '{{%schedule_category_service_assignments}}', 'service_id', '{{%schedule_services}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-schedule_category_service_assignments-category_id}}', '{{%schedule_category_service_assignments}}', 'category_id', '{{%schedule_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_category_service_assignments}}');
    }
}
