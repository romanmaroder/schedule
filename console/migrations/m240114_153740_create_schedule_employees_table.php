<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_employees}}`.
 */
class m240114_153740_create_schedule_employees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable(
            '{{%schedule_employees}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'rate_id' => $this->integer()->notNull(),
                'price_id' => $this->integer()->notNull(),
                'first_name' => $this->string()->notNull(),
                'last_name' => $this->string()->notNull(),
                'phone' => $this->string(),
                'birthday' => $this->string(),
                'address_json' => 'JSON NOT NULL',
                'color' => $this->string(),
                'role_id' => $this->integer()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(0),
            ],
            $tableOptions
        );

        $this->createIndex('{{%idx-user_schedule_employees_id}}', '{{%schedule_employees}}', 'user_id');
        $this->createIndex('{{%idx-user_schedule_employees_role_id}}', '{{%schedule_employees}}', 'role_id');

        $this->addForeignKey(
            '{{%fk-user_schedule_employees_id}}',
            '{{%schedule_employees}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            '{{%fk-role_schedule_employees_role_id}}',
            '{{%schedule_employees}}',
            'role_id',
            '{{%schedule_roles}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_employees}}');
    }
}
