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
                [1, 'admin', 'Admin'],
                [1, 'employee', 'Employee'],
                [1, 'manager', 'Manager'],
            ]
        );

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['admin', 'manager'],
            ['admin', 'employee'],
            ['manager', 'employee'],
        ]);

        $this->execute(
            'INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'admin\', e.user_id FROM {{%schedule_employees}} e ORDER BY e.user_id'
        );
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => ['user', 'admin']]);
    }

}
