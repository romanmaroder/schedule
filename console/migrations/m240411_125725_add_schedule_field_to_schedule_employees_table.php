<?php

use yii\db\Migration;

/**
 * Class m240411_125725_add_schedule_field_to_schedule_employees_table
 */
class m240411_125725_add_schedule_field_to_schedule_employees_table extends Migration
{

    public function up()
    {
        $this->addColumn('{{%schedule_employees}}','schedule_json',$this->json()->after('address_json'));
    }

    public function down()
    {
        $this->dropColumn('{{%schedule_employees}}','schedule_json');

    }

}
