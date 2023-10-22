<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_reviews}}`.
 */
class m231022_192236_create_schedule_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            '{{%schedule_reviews}}',
            [
                'id' => $this->primaryKey(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'product_id' => $this->integer()->notNull(),
                'user_id' => $this->integer()->notNull(),
                'vote' => $this->integer()->notNull(),
                'text' => $this->text()->notNull(),
                'active' => $this->boolean()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('{{%idx-schedule_reviews-product_id}}', '{{%schedule_reviews}}', 'product_id');
        $this->createIndex('{{%idx-schedule_reviews-user_id}}', '{{%schedule_reviews}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-schedule_reviews-product_id}}',
            '{{%schedule_reviews}}',
            'product_id',
            '{{%schedule_products}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-schedule_reviews-user_id}}',
            '{{%schedule_reviews}}',
            'user_id',
            '{{%users}}',
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
        $this->dropTable('{{%schedule_reviews}}');
    }
}
