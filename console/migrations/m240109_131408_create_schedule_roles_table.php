<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_roles}}`.
 */
class m240109_131408_create_schedule_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_roles}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_roles}}');
    }
}
