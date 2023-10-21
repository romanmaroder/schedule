<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_products}}`.
 */
class m231020_122829_create_schedule_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'price_old' => $this->integer(),
            'price_new' => $this->integer(),
            'price_intern' => $this->integer(),
            'price_employee' => $this->integer(),
            'rating' => $this->decimal(3, 2),
            'meta_json' => $this->text(),
        ], $tableOptions);

        $this->createIndex('{{%idx-schedule_products-code}}', '{{%schedule_products}}', 'code', true);

        $this->createIndex('{{%idx-schedule_products-category_id}}', '{{%schedule_products}}', 'category_id');
        $this->createIndex('{{%idx-schedule_products-brand_id}}', '{{%schedule_products}}', 'brand_id');

        $this->addForeignKey('{{%fk-schedule_products-category_id}}', '{{%schedule_products}}', 'category_id', '{{%schedule_categories}}', 'id');
        $this->addForeignKey('{{%fk-schedule_products-brand_id}}', '{{%schedule_products}}', 'brand_id', '{{%schedule_brands}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_products}}');
    }
}
