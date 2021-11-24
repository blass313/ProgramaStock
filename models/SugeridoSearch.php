<?php
    namespace app\models;

    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Product;

    class SugeridoSearch extends Product{
    public function rules()
    {
        return [
            [['id', 'stock','sugerido'], 'integer'],
            [['name', 'description', 'precio_por_kg', 'precio_bolsa', 'categoria'], 'safe'],
            [['cod','categoria'],'safe']
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
        public function search($params)
        {
            $query = Product::find()->where('stock < sugerido');
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>[
                    'attributes'=>['cod','name','categoria']
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
                'precio_por_kg' => $this->precio_por_kg,
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

?>