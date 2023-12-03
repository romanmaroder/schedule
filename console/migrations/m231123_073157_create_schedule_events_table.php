<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_events}}`.
 */
class m231123_073157_create_schedule_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%schedule_events}}',
            [
                'id' => $this->primaryKey(),
                'master_id' => $this->integer()->notNull(),
                'client_id' => $this->integer(),
                'notice' => $this->text(),
                'start' => $this->dateTime()->notNull(),
                'end' => $this->dateTime(),
            ],
            $tableOptions
        );
        $this->createIndex(
            '{{%idx-schedule_events-master_id}}',
            '{{%schedule_events}}',
            'master_id'
        );
        $this->createIndex(
            '{{%idx-schedule_events-client_id}}',
            '{{%schedule_events}}',
            'client_id'
        );
        $this->addForeignKey(
            '{{%fk-schedule_events-master_id}}',
            '{{%schedule_events}}',
            'master_id',
            '{{%users}}',
            'id'
        );
        $this->addForeignKey(
            '{{%fk-schedule_events-client_id}}',
            '{{%schedule_events}}',
            'client_id',
            '{{%users}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_events}}');
    }
}
