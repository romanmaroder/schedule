<?php

use yii\db\Migration;

/**
 * Class m240904_092400_add_tools_to_schedule_events_table
 */
class m240904_092400_add_tools_to_schedule_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{schedule_events}}','tools',$this->smallInteger()->after('default_color'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{schedule_events}}','tools');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240904_092400_add_tools_to_schedule_events_table cannot be reverted.\n";

        return false;
    }
    */
}
