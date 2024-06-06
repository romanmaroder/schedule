<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_tag_service_assignments}}`.
 */
class m231025_080515_create_schedule_tag_service_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%schedule_tag_service_assignments}}',
            [
                'service_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
        $this->addPrimaryKey(
            '{{%pk-schedule_tag_service_assignments}}',
            '{{%schedule_tag_service_assignments}}',
            ['service_id', 'tag_id']
        );

        $this->createIndex(
            '{{%idx-schedule_tag_service_assignments-service_id}}',
            '{{%schedule_tag_service_assignments}}',
            'service_id'
        );
        $this->createIndex('{{%idx-schedule_tag_service_assignments-tag_id}}', '{{%schedule_tag_service_assignments}}', 'tag_id');

        $this->addForeignKey(
            '{{%fk-schedule_tag_service_assignments-service_id}}',
            '{{%schedule_tag_service_assignments}}',
            'service_id',
            '{{%schedule_services}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-schedule_tag_service_assignments-tag_id}}',
            '{{%schedule_tag_service_assignments}}',
            'tag_id',
            '{{%schedule_service_tags}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_tag_service_assignments}}');
    }
}
