<?php
    namespace app\models;
    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Facturacion;
    
    class FacturacionSearch extends Facturacion
    {
        public $fechaDesde;
        public $fechaHasta;
        public $año;

        public function validateDates($attribute){
            if(!$this->hasErrors() && strtotime($this->fechaDesde) > strtotime($this->fechaHasta)){
                $this->addError('fechaDesde','escriba de forma correcta el rango');
            }
        }

        public function scenarios(){
            return Model::scenarios();
        }

        public function searchFacturacion($params){
            $query = Facturacion::find()->orderBy(['fecha'=>SORT_DESC]);

            $dataFacturacion = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
    
            $this->load($params);
    
            if (!$this->validate()) {
                return $dataFacturacion;
            }
            
            $query->andFilterWhere([
                'id' => $this->id,
                'fecha' => $this->fecha,
                'ingreso' => $this->ingreso,
                'salida' => $this->salida,
                'personas' => $this->personas,
            ]);
            
            return $dataFacturacion;
        }
    }
?>