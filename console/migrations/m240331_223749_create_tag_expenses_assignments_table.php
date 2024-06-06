<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_expenses_assignments}}`.
 */
class m240331_223749_create_tag_expenses_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%tag_expenses_assignments}}',
            [
                'expense_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
        $this->addPrimaryKey(
            '{{%pk-tag_expenses_assignments}}',
            '{{%tag_expenses_assignments}}',
            ['expense_id', 'tag_id']
        );

        $this->createIndex(
            '{{%idx-tag_expenses_assignments-expense_id}}',
            '{{%tag_expenses_assignments}}',
            'expense_id'
        );
        $this->createIndex('{{%idx-tag_expenses_assignments-tag_id}}', '{{%tag_expenses_assignments}}', 'tag_id');

        $this->addForeignKey(
            '{{%fk-tag_expenses_assignments-expense_id}}',
            '{{%tag_expenses_assignments}}',
            'expense_id',
            '{{%expenses}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-tag_expenses_assignments-tag_id}}',
            '{{%tag_expenses_assignments}}',
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
        $this->dropTable('{{%tag_expenses_assignments}}');
    }
}
