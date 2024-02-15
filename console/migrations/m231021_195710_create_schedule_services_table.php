<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_services}}`.
 */
class m231021_195710_create_schedule_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_services}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price_old' => $this->integer(),
            'price_new' => $this->integer(),
            'meta_json' => $this->text(),
            'status' => $this->smallInteger()->defaultValue(1)->notNull(),
        ], $tableOptions);


        $this->createIndex('{{%idx-schedule_services-category_id}}', '{{%schedule_services}}', 'category_id');

        $this->addForeignKey('{{%fk-schedule_services-category_id}}', '{{%schedule_services}}', 'category_id', '{{%schedule_categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_services}}');
    }
}
