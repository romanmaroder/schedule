<?php

use yii\db\Migration;

/**
 * Class m240410_101744_add_payment_field_to_schedule_events_table
 */
class m240410_101744_add_payment_field_to_schedule_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
$this->addColumn('{{schedule_events}}','payment',$this->smallInteger()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{schedule_events}}','payment');
    }

}
