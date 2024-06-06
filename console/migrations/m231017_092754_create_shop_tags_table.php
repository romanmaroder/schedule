<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_tags}}`.
 */
class m231017_092754_create_shop_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_tags}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'slug'=>$this->string()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-shop_tags-slug}}','{{%shop_tags}}','slug',true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%shop_tags}}');
    }
}
