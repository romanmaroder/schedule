<?php

use yii\db\Migration;

/**
 * Class m240317_072355_add_cost_field_to_schedule_service_assignments_table
 */
class m240317_072355_add_additional_field_to_schedule_service_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_service_assignments}}', 'original_cost', $this->integer()->after('service_id'));
        $this->addColumn('{{%schedule_service_assignments}}', 'price_rate', $this->integer()->after('original_cost'));
        $this->addColumn('{{%schedule_service_assignments}}', 'price_cost', $this->integer()->after('price_rate'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%schedule_service_assignments}}', 'original_cost');
        $this->dropColumn('{{%schedule_service_assignments}}', 'price_rate');
        $this->dropColumn('{{%schedule_service_assignments}}', 'price_cost');
    }
}
