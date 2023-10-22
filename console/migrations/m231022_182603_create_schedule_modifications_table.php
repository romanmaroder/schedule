<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_modifications}}`.
 */
class m231022_182603_create_schedule_modifications_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            '{{%schedule_modifications}}',
            [
                'id' => $this->primaryKey(),
                'product_id' => $this->integer()->notNull(),
                'code' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'price' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex('{{%idx-schedule_modifications-code}}', '{{%schedule_modifications}}', 'code');
        $this->createIndex(
            '{{%idx-schedule_modifications-product_id-code}}',
            '{{%schedule_modifications}}',
            ['product_id', 'code'],
            true
        );
        $this->createIndex('{{%idx-schedule_modifications-product_id}}', '{{%schedule_modifications}}', 'product_id');

        $this->addForeignKey(
            '{{%fk-schedule_modifications-product_id}}',
            '{{%schedule_modifications}}',
            'product_id',
            '{{%schedule_products}}',
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
        $this->dropTable('{{%schedule_modifications}}');
    }
}
