<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_educations}}`.
 */
class m231203_142445_create_schedule_educations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_educations}}', [
            'id' => $this->primaryKey(),
            'teacher_id'=>$this->integer()->notNull(),
            'student_ids'=>'JSON NOT NULL',
            'title'=>$this->string(),
            'description'=>$this->text(),
            'color'=>$this->string()->notNull()->defaultValue('#474D2A'),
            'start' => $this->dateTime()->notNull(),
            'end' => $this->dateTime(),
            'status'=>$this->smallInteger()->notNull()->defaultValue(0)
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('{{%schedule_educations}}');
    }
}
