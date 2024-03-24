<?php

use yii\db\Migration;

/**
 * Class m240317_072036_add_discounts_amount_status_fields_to_schedule_events_table
 */
class m240317_072036_add_discounts_amount_status_fields_to_schedule_events_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_events}}', 'discount', $this->integer()->after('notice'));
        $this->addColumn('{{%schedule_events}}', 'discount_from', $this->smallInteger()->after('discount'));
        $this->addColumn('{{%schedule_events}}', 'amount', $this->integer()->after('discount_from'));
        $this->addColumn('{{%schedule_events}}', 'status', $this->smallInteger()->after('amount'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%schedule_events}}', 'discount');
        $this->dropColumn('{{%schedule_events}}', 'discount_from');
        $this->dropColumn('{{%schedule_events}}', 'amount');
        $this->dropColumn('{{%schedule_events}}', 'status');
    }
}
