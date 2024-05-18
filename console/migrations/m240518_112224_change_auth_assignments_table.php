<?php

use yii\db\Migration;

/**
 * Class m240518_112224_change_auth_assignments_table
 */
class m240518_112224_change_auth_assignments_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->integer()->notNull());

        $this->createIndex('{{%idx-auth_assignments-employee_id}}', '{{%auth_assignments}}', 'user_id');

        $this->addForeignKey('{{%fk-auth_assignments-employee_id}}', '{{%auth_assignments}}', 'user_id', '{{%schedule_employees}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-auth_assignments-employee_id}}', '{{%auth_assignments}}');

        $this->dropIndex('{{%idx-auth_assignments-employee_id}}', '{{%auth_assignments}}');

        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->string(64)->notNull());
    }
}
