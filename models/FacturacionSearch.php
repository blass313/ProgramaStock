<?php
    namespace app\models;

    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Facturacion;
    
    class FacturacionSearch extends Facturacion
    {

        public function rules()
        {
            return [
                [['id', 'ingreso', 'salida', 'personas'], 'integer'],
                [['fecha','fechaDesde','fechaHasta'], 'safe'],
                
            ];
        }

        public function scenarios(){
            return Model::scenarios();
        }

        public function search($params){
            $query = Facturacion::find();

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
    
            $this->load($params);
    
            if (!$this->validate()) {
                return $dataProvider;
            }
            
            $query->andFilterWhere([
                'id' => $this->id,
                'fecha' => $this->fecha,
                'ingreso' => $this->ingreso,
                'salida' => $this->salida,
                'personas' => $this->personas,
            ]);
            
            return $dataProvider;
        }
    }
?>