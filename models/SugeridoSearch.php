<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

class SugeridoSearch extends Product
{
    public function rules(){
        return [
            [['id', 'stock','sugerido'], 'integer'],
            [['name', 'description', 'kg', 'precio_bolsa', 'categoria'], 'safe'],
            [['cod','categoria'],'safe']
        ];
    }

    public function scenarios(){
        return Model::scenarios();
    }

    public function searchSugerido($params){
        $query = Product::find()->where('stock < sugerido');

        $dataSugerido = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['name']],
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataSugerido;
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
        
        return $dataSugerido;
    }
}