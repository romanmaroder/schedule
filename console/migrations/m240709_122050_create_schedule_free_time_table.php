<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_free_time}}`.
 */
class m240709_122050_create_schedule_free_time_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_free_time}}', [
            'id' => $this->primaryKey(),
            'master_id'=>$this->integer()->notNull(),
            'additional_id'=>$this->integer()->notNull(),
            'notice' => $this->text(),
            'start' => $this->dateTime()->notNull(),
            'end' => $this->dateTime(),
        ],$tableOptions);

        $this->createIndex(
            '{{%idx-schedule_free_time-master_id}}',
            '{{%schedule_free_time}}',
            'master_id'
        );
        $this->createIndex(
            '{{%idx-schedule_free_time-additional_id}}',
            '{{%schedule_free_time}}',
            'additional_id'
        );
        $this->addForeignKey(
            '{{%fk-schedule_free_time-master_id}}',
            '{{%schedule_free_time}}',
            'master_id',
            '{{%users}}',
            'id'
        );
        $this->addForeignKey(
            '{{%fk-schedule_free_time-additional_id}}',
            '{{%schedule_free_time}}',
            'additional_id',
            '{{%schedule_additional}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_free_time}}');
    }
}
