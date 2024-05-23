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
                [2, 'permission_admin', 'Admin permission'],
                [2, 'permission_employee', 'Employee permission'],
                [2, 'permission_manager', 'Manager permission'],

                [2, 'permission_create_client', 'Creating a client'],
                [2, 'permission_update_client', 'Updating a client'],
                [2, 'permission_delete_client', 'Deleting a client'],
                [2, 'permission_view_client', 'Client view'],

                [2, 'permission_create_employee', 'Creating a employee'],
                [2, 'permission_update_employee', 'Updating a employee'],
                [2, 'permission_delete_employee', 'Deleting a employee'],
                [2, 'permission_view_employee', 'Employee view'],

                [2, 'permission_create_post', 'Article creation'],
                [2, 'permission_update_post', 'Editing an article'],
                [2, 'permission_delete_post', 'Deleting an article'],
                [2, 'permission_view_post', 'Viewing an article'],
            ]
        );

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['admin', 'manager'],
            ['admin', 'employee'],
            ['manager', 'employee'],
            ['admin', 'permission_admin'],
            ['admin', 'permission_create_client'],
            ['admin', 'permission_update_client'],
            ['admin', 'permission_delete_client'],
            ['admin', 'permission_view_client'],
            ['admin', 'permission_create_employee'],
            ['admin', 'permission_update_employee'],
            ['admin', 'permission_delete_employee'],
            ['admin', 'permission_view_employee'],
            ['admin', 'permission_create_post'],
            ['admin', 'permission_update_post'],
            ['admin', 'permission_delete_post'],
            ['admin', 'permission_view_post'],

            ['employee', 'permission_employee'],
            ['employee', 'permission_view_client'],
            ['employee', 'permission_view_employee'],
            ['employee', 'permission_view_post'],

            ['manager', 'permission_manager'],
            ['manager', 'permission_create_client'],
            ['manager', 'permission_update_client'],
            ['manager', 'permission_delete_client'],
            ['manager', 'permission_view_client'],
            ['manager', 'permission_create_employee'],
            ['manager', 'permission_update_employee'],
            ['manager', 'permission_delete_employee'],
            ['manager', 'permission_view_employee'],
            ['manager', 'permission_create_post'],
            ['manager', 'permission_update_post'],
            ['manager', 'permission_delete_post'],
            ['manager', 'permission_view_post'],
        ]);

        $this->execute(
            'INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'admin\', e.user_id FROM {{%schedule_employees}} e ORDER BY e.user_id'
        );
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => ['admin','employee','manager']]);
    }

}
