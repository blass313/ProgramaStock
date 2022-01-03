<?php
    namespace app\models;

    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Facturacion;
    
    class FacturacionSearch extends Facturacion
    {
        public $fechaDesde;
        public $fechaHasta;
        public $año;

        public function rules()
        {
            return [
                [['id', 'ingreso', 'salida', 'personas'], 'integer'],
                [['fecha','fechaDesde','fechaHasta','año'], 'safe'],
                
            ];
        }

        public function scenarios(){
            return Model::scenarios();
        }

        public function search($params){
            $query = Facturacion::find()->orderBy(['fecha'=>SORT_DESC]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
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