<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_expenses_assignments}}`.
 */
class m240331_224516_create_category_expenses_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%category_expenses_assignments}}', [
            'expense_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->addPrimaryKey('{{%pk-category_expenses_assignments}}',
                             '{{%category_expenses_assignments}}',
                             [ 'expense_id', 'category_id']);

        $this->createIndex('{{%idx-category_expenses_assignments-expense_id}}',
                           '{{%category_expenses_assignments}}', 'expense_id');
        $this->createIndex('{{%idx-category_expenses_assignments-category_id}}',
                           '{{%category_expenses_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-category_expenses_assignments-expense_id}}',
                             '{{%category_expenses_assignments}}', 'expense_id',
                             '{{%expenses}}', 'id', 'CASCADE',
                             'RESTRICT');
        $this->addForeignKey('{{%fk-category_expenses_assignments-category_id}}',
                             '{{%category_expenses_assignments}}', 'category_id',
                             '{{%expenses_categories}}', 'id', 'CASCADE',
                             'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%category_expenses_assignments}}');
    }
}
