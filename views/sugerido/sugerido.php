<?php
    namespace app\view;


    use yii\helpers\ArrayHelper;
    use yii\grid\GridView;

    use app\models\Product;
    use app\models\SugeridoSearch;
?>

<?=
    GridView::widget([
    'dataProvider' =>$dataProvider,
    'filterModel' => $searchModel,
    'columns'=>[
        'cod',
        [
            'attribute'=>'name',
            'label'=>'Producto'
        ],
        [
            'attribute'=>'categoria',
            'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria")
        ],
        [
            'attribute'=>'stock',
        ],                      
            'sugerido',
        [
            'label'=>'diferencia',
            'value'=>$dif = function($model){
                $diferencia = $model['sugerido']-$model['stock'];
                return $diferencia;
            },
        ],
        ],
    ]);?>