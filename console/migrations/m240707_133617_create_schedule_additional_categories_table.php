<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_additional_categories}}`.
 */
class m240707_133617_create_schedule_additional_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_additional_categories}}', [
            'id' => $this->primaryKey(),'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-schedule_service_categories-slug}}', '{{%schedule_additional_categories}}', 'slug', true);

        $this->insert('{{%schedule_additional_categories}}', [
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
        $this->dropTable('{{%schedule_additional_categories}}');
    }
}
