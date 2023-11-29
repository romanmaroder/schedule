<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_service_assignments}}`.
 */
class m231123_073605_create_schedule_service_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            '{{%schedule_service_assignments}}',
            [
                'event_id' => $this->integer()->notNull(),
                'service_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey(
            '{{%pk-schedule_service_assignments}}',
            '{{%schedule_service_assignments}}',
            ['event_id', 'service_id']
        );
        $this->createIndex('{{%idx-schedule_service_assignments-event_id}}',
                           '{{%schedule_service_assignments}}', 'event_id');

        $this->createIndex('{{%idx-schedule_service_assignments-service_id}}',
                           '{{%schedule_service_assignments}}', 'service_id');

        $this->addForeignKey('{{%fk-schedule_service_assignments-event_id}}',
                             '{{%schedule_service_assignments}}', 'event_id',
                             '{{%schedule_events}}', 'id', 'CASCADE',
                             'RESTRICT');

        $this->addForeignKey('{{%fk-schedule_service_assignments-service_id}}',
                             '{{%schedule_service_assignments}}', 'service_id',
                             '{{%schedule_services}}', 'id', 'CASCADE',
                             'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_service_assignments}}');
    }
}
