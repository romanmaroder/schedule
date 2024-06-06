<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_service_categories}}`.
 */
class m231019_065253_create_schedule_service_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_service_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-schedule_service_categories-slug}}', '{{%schedule_service_categories}}', 'slug', true);

        $this->insert('{{%schedule_service_categories}}', [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_service_categories}}');
    }
}
