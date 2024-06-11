<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses_category_assignments}}`.
 */
class m240331_224516_create_expenses_category_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%expenses_category_assignments}}', [
            'expense_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->addPrimaryKey('{{%pk-expenses_category_assignments}}',
                             '{{%expenses_category_assignments}}',
                             [ 'expense_id', 'category_id']);

        $this->createIndex('{{%idx-expenses_category_assignments-expense_id}}',
                           '{{%expenses_category_assignments}}', 'expense_id');
        $this->createIndex('{{%idx-expenses_category_assignments-category_id}}',
                           '{{%expenses_category_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-expenses_category_assignments-expense_id}}',
                             '{{%expenses_category_assignments}}', 'expense_id',
                             '{{%expenses}}', 'id', 'CASCADE',
                             'RESTRICT');
        $this->addForeignKey('{{%fk-expenses_category_assignments-category_id}}',
                             '{{%expenses_category_assignments}}', 'category_id',
                             '{{%expenses_categories}}', 'id', 'CASCADE',
                             'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%expenses_category_assignments}}');
    }
}
