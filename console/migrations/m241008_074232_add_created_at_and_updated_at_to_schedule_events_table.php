<?php

use yii\db\Migration;

/**
 * Class m241008_074232_add_created_at_and_updated_at_to_schedule_events_table
 */
class m241008_074232_add_created_at_and_updated_at_to_schedule_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%schedule_events}}', 'created_at', $this->integer()->unsigned()->notNull()->after('default_color'));
        $this->addColumn('{{%schedule_events}}', 'updated_at', $this->integer()->unsigned()->notNull()->after('created_at'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%schedule_events}}', 'created_at');
        $this->dropColumn('{{%schedule_events}}', 'updated_at');
    }

}
