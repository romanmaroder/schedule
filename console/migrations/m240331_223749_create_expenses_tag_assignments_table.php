<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses_tag_assignments}}`.
 */
class m240331_223749_create_expenses_tag_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%expenses_tag_assignments}}',
            [
                'expense_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
        $this->addPrimaryKey(
            '{{%pk-expenses_tag_assignments}}',
            '{{%expenses_tag_assignments}}',
            ['expense_id', 'tag_id']
        );

        $this->createIndex(
            '{{%idx-expenses_tag_assignments-expense_id}}',
            '{{%expenses_tag_assignments}}',
            'expense_id'
        );
        $this->createIndex('{{%idx-expenses_tag_assignments-tag_id}}',
                           '{{%expenses_tag_assignments}}',
                           'tag_id');

        $this->addForeignKey(
            '{{%fk-expenses_tag_assignments-expense_id}}',
            '{{%expenses_tag_assignments}}',
            'expense_id',
            '{{%expenses}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-expenses_tag_assignments-tag_id}}',
            '{{%expenses_tag_assignments}}',
            'tag_id',
            '{{%expenses_tags}}',
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
        $this->dropTable('{{%expenses_tag_assignments}}');
    }
}
