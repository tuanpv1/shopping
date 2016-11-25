<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m161121_103312_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status' => $this->integer(3),
            'name_buyer' => $this->string(),
            'phone_buyer' => $this->integer(),
            'address_buyer' => $this->string(),
            'email_buyer' => $this->string(),
            'email_receiver' => $this->string(),
            'name_receiver' => $this->string(),
            'phone_receiver' => $this->integer(),
            'address_receiver' => $this->string(),
            'total' => $this->integer(),
            'total_number' => $this->integer(),
            'created_at' => $this->integer(),
            'note' => $this->text(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
