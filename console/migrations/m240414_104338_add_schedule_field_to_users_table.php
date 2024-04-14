<?php

use yii\db\Migration;

/**
 * Class m240414_104338_add_schedule_field_to_users_table
 */
class m240414_104338_add_schedule_field_to_users_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}','schedule_json',$this->json()->notNull()->after('status'));
    }

    public function down()
    {
        $this->dropColumn('{{%users}}','schedule_json');

    }
}
