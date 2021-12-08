<?php
    namespace app\models;

    use yii\base\Model;
    use yii\data\ActiveDataProvider;

    use app\models\Facturacion;

    class FacturacionSearch extends Facturacion{
        public function scenarios(){
            return Model::scenarios();
        }

        public function search($params){

            $query = Facturacion::find();

            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);

            $this->load($params);

            if (!$this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere([
                'id'=>$this->id,
                'fecha'=>$this->fecha,
                'ingreso'=>$this->ingreso,
                'salida'=>$this->salida,
                'personas'=>$this->personas,
            ])

            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'personas', $this->personas]);
            return $dataProvider;
        }//search
    }//class

?>