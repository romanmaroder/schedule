<?php

use yii\db\Migration;

/**
 * Class m240317_072036_add_secondary_fields_to_schedule_events_table
 */
class m240317_072036_add_secondary_fields_to_schedule_events_table extends Migration
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
        $this->addColumn('{{%schedule_events}}', 'rate', $this->decimal(3,2)->after('status'));
        $this->addColumn('{{%schedule_events}}', 'price', $this->decimal(3,2)->after('rate'));
        $this->addColumn('{{%schedule_events}}', 'fullname', $this->string()->after('price'));
        $this->addColumn('{{%schedule_events}}', 'default_color', $this->string()->defaultValue('#747d8c')->after('fullname'));
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
        $this->dropColumn('{{%schedule_events}}', 'rate');
        $this->dropColumn('{{%schedule_events}}', 'price');
        $this->dropColumn('{{%schedule_events}}', 'fullname');
        $this->dropColumn('{{%schedule_events}}', 'default_color');
    }
}
