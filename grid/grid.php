<?php
    namespace app\models;
    use app\models\Product;
    use app\models\ProductForm;
    use yii\db\ActiveQuery;
    use yii\grid\DataColumn;
    
    class grid extends DataColumn
    {
        public static function color($cod){
            $BBDD = new Product();

            $dato = $BBDD->find()->asArray()->where(['cod'=>$cod])->one();
            if(isset($dato['stock'])&&isset($dato['sugerido'])){
                $stock = $dato['stock'];
                $sugerido = $dato['sugerido'];

                $diferencia = $stock - $sugerido;

                if ($diferencia < 0) {
                    $color = 'red';
                    return $color;
                }elseif($diferencia == 0){
                    $color = 'yellow';
                    return $color;
                }else {
                    $color = 'green';
                    return $color;
                }
            }
        }
    }
    
?>