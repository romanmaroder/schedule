<?php

use yii\db\Migration;

/**
 * Class m240317_072355_add_cost_field_to_schedule_service_assignments_table
 */
class m240317_072355_add_cost_field_to_schedule_service_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_service_assignments}}', 'cost', $this->integer()->after('service_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%schedule_service_assignments}}', 'cost');
    }
}
