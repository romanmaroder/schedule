<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_additional}}`.
 */
class m240707_144154_create_schedule_additional_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_additional}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'meta_json' => $this->text(),
            'status' => $this->smallInteger()->defaultValue(1)->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-schedule_additional-category_id}}', '{{%schedule_additional}}', 'category_id');

        $this->addForeignKey('{{%fk-schedule_additional-category_id}}', '{{%schedule_additional}}', 'category_id', '{{%schedule_additional_categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_additional}}');
    }
}
