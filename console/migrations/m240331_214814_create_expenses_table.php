<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses}}`.
 */
class m240331_214814_create_expenses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%expenses}}',
            [
                'id' => $this->primaryKey(),
                'category_id'=>$this->integer()->notNull(),
                'name' => $this->string(255)->notNull(),
                'value' => $this->integer()->notNull(),
                'status'=>$this->smallInteger(),
                'created_at' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('{{%idx-expenses-category_id}}', '{{%expenses}}', 'category_id');

        $this->addForeignKey('{{%fk-expenses-category_id}}', '{{%expenses}}', 'category_id', '{{%expenses_categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%expenses}}');
    }
}
