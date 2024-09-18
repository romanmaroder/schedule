<?php

use yii\db\Migration;

/**
 * Class m240918_132217_remove_the_price_column_from_the_service_assignment_table
 */
class m240918_132217_remove_the_price_column_from_the_service_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
$this->dropColumn('{{schedule_events}}','price');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('{{schedule_events}}','price',$this->integer()->after('rate'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240918_132217_remove_the_price_column_from_the_service_assignment_table cannot be reverted.\n";

        return false;
    }
    */
}
