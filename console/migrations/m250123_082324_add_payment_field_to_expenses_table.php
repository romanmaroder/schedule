<?php

use yii\db\Migration;

/**
 * Class m250123_082324_add_payment_field_to_expenses_table
 */
class m250123_082324_add_payment_field_to_expenses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
$this->addColumn('{{expenses}}', 'payment', $this->smallInteger()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
       $this->dropColumn('{{expenses}}', 'payment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250123_082324_add_payment_field_to_expenses_table cannot be reverted.\n";

        return false;
    }
    */
}
