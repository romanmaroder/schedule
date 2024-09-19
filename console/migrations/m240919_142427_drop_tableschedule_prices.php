<?php

use yii\db\Migration;

/**
 * Class m240919_142427_drop_tableschedule_prices
 */
class m240919_142427_drop_tableschedule_prices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropTable('{{%schedule_prices}}');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m240919_142427_drop_tableschedule_prices cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240919_142427_drop_tableschedule_prices cannot be reverted.\n";

        return false;
    }
    */
}
