<?php

use yii\db\Migration;

/**
 * Class m240907_231309_changing_the_type_of_the_price_column_in_the_schedule_events_table
 */
class m240907_231309_changing_the_type_of_the_price_column_in_the_schedule_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('{{%schedule_events}}','price',$this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->alterColumn('{{%schedule_prices}}','rate',$this->decimal(3,2));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240907_231309_changing_the_type_of_the_price_column_in_the_schedule_events_table cannot be reverted.\n";

        return false;
    }
    */
}
