<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report`.
 */
class m161125_052152_create_report_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('report', [
            'id' => $this->primaryKey(),
            'date' => $this->date(),
            'total' => $this->integer(),
            'number' => $this->integer(),
            'number_success' => $this->integer(),
            'number_error' => $this->integer(),
            'number_tranport' => $this->integer(),
            'number_return' => $this->integer(),
            'number_ordered' => $this->integer(),
            'total_success' => $this->integer(),
            'total_error' => $this->integer(),
            'total_tranport' => $this->integer(),
            'total_return' => $this->integer(),
            'total_ordered' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('report');
    }
}
