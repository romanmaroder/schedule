<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule_multiprice_assignments}}`.
 */
class m240911_083349_create_schedule_multiprice_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%schedule_multiprice_assignments}}', [
            'price_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'rate'=>$this->integer(),
            'cost'=>$this->integer(),
        ],$tableOptions);

        $this->addPrimaryKey(
            '{{%pk-schedule_multiprice_assignments}}',
            '{{%schedule_multiprice_assignments}}',
            ['price_id', 'service_id']
        );
        $this->createIndex('{{%idx-schedule_multiprice_assignments-price_id}}',
                           '{{%schedule_multiprice_assignments}}', 'price_id');

        $this->createIndex('{{%idx-schedule_multiprice_assignments-service_id}}',
                           '{{%schedule_multiprice_assignments}}', 'service_id');

        $this->addForeignKey('{{%fk-schedule_multiprice_assignments-price_id}}',
                             '{{%schedule_multiprice_assignments}}', 'price_id',
                             '{{%schedule_multiprices}}', 'id', 'CASCADE',
                             'RESTRICT');

        $this->addForeignKey('{{%fk-schedule_multiprice_assignments-service_id}}',
                             '{{%schedule_multiprice_assignments}}', 'service_id',
                             '{{%schedule_services}}', 'id', 'CASCADE',
                             'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%schedule_multiprice_assignments}}');
    }
}
