<?php

use yii\db\Migration;

/**
 * Class m240518_112304_add_employee_roles
 */
class m240518_112304_add_employee_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            '{{%auth_items}}',
            ['type', 'name', 'description'],
            [
                [1, 'employee', 'Employee'],
                [1, 'manager', 'Manager'],
                [1, 'admin', 'Admin'],
            ]
        );

        $this->batchInsert(
            '{{%auth_item_children}}',
            ['parent', 'child'],
            [
                ['admin', 'employee', 'manager'],
            ]
        );

        $this->execute(
            'INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'employee\', e.id FROM {{%schedule_employees}} e ORDER BY e.id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%auth_items}}', ['name' => ['employee', 'manager', 'admin']]);
    }

}
