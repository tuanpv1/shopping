<?php

use yii\db\Migration;

/**
 * Handles the creation for table `product`.
 */
class m160918_143716_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'name' => $this->string(),
            'des' => $this->text(),
            'price' => $this->integer(),
            'id_category' => $this->integer(11),
            'id_produce' => $this->integer(11),
            'chip' => $this->string(),
            'type_ram' => $this->string(),
            'type_hdd' => $this->string(),
            'size' => $this->string(),
            'touch' => $this->integer(3),
            'is_banner' => $this->integer(3),
            'graphics' => $this->string(),
            'pin' => $this->string(),
            'weight' => $this->string(),
            'os' => $this->string(),
            'Processor' => $this->string(),
            'type_cpu' => $this->string(),
            'product_cpu' => $this->string(),
            'speed_cpu' => $this->string(),
            'cache' => $this->string(),
            'speed_max' => $this->string(),
            'motherboard' => $this->string(),
            'Chipset' => $this->string(),
            'technology_cpu' => $this->string(),
            'wifi' => $this->string(),
            'hdmi' => $this->string(),
            'color' => $this->string(),
            'webcam' => $this->string(),
            'lan' => $this->integer(3),
            'dvd' => $this->integer(3),
            'sale' => $this->integer(),
            'speed_bus' => $this->integer(),
            'max_ram' => $this->integer(),
            'ram' => $this->integer(),
            'hdd' => $this->integer(),
            'status' => $this->integer(5),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
