<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_service_tags}}`.
 */
class m231017_092754_create_schedule_service_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule_service_tags}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'slug'=>$this->string()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-schedule_service_tags-slug}}','{{%schedule_service_tags}}','slug',true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_service_tags}}');
    }
}
