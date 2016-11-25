<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price','id_category', 'id_produce', 'touch', 'lan', 'dvd', 'is_banner','sale', 'speed_bus', 'max_ram', 'ram', 'hdd', 'status', 'created_at', 'updated_at'], 'integer'],
            [['image', 'name', 'des', 'chip', 'type_ram', 'type_hdd', 'size', 'graphics', 'pin', 'weight', 'os', 'Processor', 'type_cpu', 'product_cpu', 'speed_cpu', 'cache', 'speed_max', 'motherboard', 'Chipset', 'technology_cpu', 'wifi', 'hdmi', 'color', 'webcam'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'is_banner' => $this->is_banner,
            'id_produce' => $this->id_produce,
            'id_category' => $this->id_category,
            'touch' => $this->touch,
            'lan' => $this->lan,
            'dvd' => $this->dvd,
            'sale' => $this->sale,
            'speed_bus' => $this->speed_bus,
            'max_ram' => $this->max_ram,
            'ram' => $this->ram,
            'hdd' => $this->hdd,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'chip', $this->chip])
            ->andFilterWhere(['like', 'type_ram', $this->type_ram])
            ->andFilterWhere(['like', 'type_hdd', $this->type_hdd])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'graphics', $this->graphics])
            ->andFilterWhere(['like', 'pin', $this->pin])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'Processor', $this->Processor])
            ->andFilterWhere(['like', 'type_cpu', $this->type_cpu])
            ->andFilterWhere(['like', 'product_cpu', $this->product_cpu])
            ->andFilterWhere(['like', 'speed_cpu', $this->speed_cpu])
            ->andFilterWhere(['like', 'cache', $this->cache])
            ->andFilterWhere(['like', 'speed_max', $this->speed_max])
            ->andFilterWhere(['like', 'motherboard', $this->motherboard])
            ->andFilterWhere(['like', 'Chipset', $this->Chipset])
            ->andFilterWhere(['like', 'technology_cpu', $this->technology_cpu])
            ->andFilterWhere(['like', 'wifi', $this->wifi])
            ->andFilterWhere(['like', 'hdmi', $this->hdmi])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'webcam', $this->webcam]);

        return $dataProvider;
    }
}
