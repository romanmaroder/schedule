<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses_tags}}`.
 */
class m240331_214815_create_expenses_tags_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%expenses_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-expenses_tags-slug}}', '{{%expenses_tags}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%expenses_tags}}');
    }
}
