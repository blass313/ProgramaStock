<?php
    namespace app\models;

    use yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Distribuidora;

    class DistribuidoraSearch extends Distribuidora
    {
        public function scenarios()
        {
            return Model::scenarios();
        }

        public function search($params){
            $query = Distribuidora::find();

            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);

            if (!$this->validate()) {
                return $dataProvider;
            }
        }
    }
    
?>