<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

class ProductSearch extends Product
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
    
    public function searchGeneral($params){
            $query = Product::find()->orderBy(['name'=>SORT_ASC]);
            $pagination = false;
        

        $dataGeneral = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['name']],
            'pagination' => [
                'pageSize' => $pagination,
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataGeneral;
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
        
        return $dataGeneral;
    }
}
