<?php

use yii\db\Migration;

/**
 * Handles the creation of table `produce`.
 */
class m161117_125314_create_produce_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('produce', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'id_cat' => $this->integer(),
            'address' => $this->string(),
            'phone' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('produce');
    }
}
