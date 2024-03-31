<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses_categories}}`.
 */
class m240331_205709_create_expenses_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%expenses_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-expenses_categories-slug}}', '{{%expenses_categories}}', 'slug', true);

        $this->insert('{{%expenses_categories}}', [
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
        $this->dropTable('{{%expenses_categories}}');
    }
}
