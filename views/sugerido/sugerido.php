<?php
    namespace app\view;
    
    use yii\helpers\ArrayHelper;
    use yii\grid\GridView;
    use app\controllers\SiteController;
    use yii\helpers\Html;

    use app\models\Product;
?>
    <div>
        <h1>Sugerido</h1>
    </div>
    <?= Html::a('Exportar a PDF',['pdf'],['class'=>'btn btn-info'])?>
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
            'label'=>'Proveedor',
            'filter'=>$filtro = ArrayHelper::map(product::find()->all(), "categoria","categoria")
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