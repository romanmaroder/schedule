<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_photos}}`.
 */
class m231021_163820_create_schedule_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_photos}}', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer()->notNull(),
            'file'=>$this->string()->notNull(),
            'sort'=>$this->integer()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-schedule_photos-product_id}}', '{{%schedule_photos}}', 'product_id');

        $this->addForeignKey('{{%fk-schedule_photos-product_id}}', '{{%schedule_photos}}', 'product_id', '{{%schedule_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_photos}}');
    }
}
