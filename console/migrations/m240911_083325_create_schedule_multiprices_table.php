<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_multiprices}}`.
 */
class m240911_083325_create_schedule_multiprices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_multiprices}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'rate'=>$this->integer(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_multiprices}}');
    }
}
