<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_category_additional_assignments}}`.
 */
class m240707_145510_create_schedule_category_additional_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_category_additional_assignments}}', [
            'additional_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->addPrimaryKey('{{%pk-schedule_category_additional_assignments}}',
                             '{{%schedule_category_additional_assignments}}',
                             [ 'additional_id', 'category_id']);

        $this->createIndex('{{%idx-schedule_category_additional_assignments-additional_id}}',
                           '{{%schedule_category_additional_assignments}}', 'additional_id');
        $this->createIndex('{{%idx-schedule_category_additional_assignments-category_id}}',
                           '{{%schedule_category_additional_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-schedule_category_additional_assignments-additional_id}}',
                             '{{%schedule_category_additional_assignments}}', 'additional_id',
                             '{{%schedule_additional}}', 'id', 'CASCADE',
                             'RESTRICT');
        $this->addForeignKey('{{%fk-schedule_category_additional_assignments-category_id}}',
                             '{{%schedule_category_additional_assignments}}', 'category_id',
                             '{{%schedule_additional_categories}}', 'id', 'CASCADE',
                             'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_category_additional_assignments}}');
    }
}
