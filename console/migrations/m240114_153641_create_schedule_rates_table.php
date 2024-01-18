<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_rates}}`.
 */
class m240114_153641_create_schedule_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_rates}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'rate'=>$this->decimal(3,2),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_rates}}');
    }
}
