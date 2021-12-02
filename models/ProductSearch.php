<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

class ProductSearch extends Product
{
    public function rules()
    {
        return [
            [['id', 'stock','sugerido'], 'integer'],
            [['name', 'description', 'kg', 'precio_bolsa', 'categoria'], 'safe'],
            [['cod','categoria'],'safe']
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params,$section = null)
    {
        if ($section == 'sugerido') {
            $query = Product::find()->where('stock < sugerido');
        }else{
            $query = Product::find();
        }
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'attributes'=>['cod','name']
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cod' => $this->cod,
            'categoria' => $this->categoria,
            'stock' => $this->stock,
            'sugerido' => $this->sugerido,
            'kg' => $this->kg,
            'precio_bolsa' => $this->precio_bolsa,
            'porcentajekg' => $this->porcentajekg,
            'porcentajebolsa' => $this->porcentajebolsa,
            'name' => $this->name
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
