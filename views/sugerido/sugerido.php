<?php
    namespace app\view;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\bootstrap4\Modal;

    use app\models\Product;
?>
    <div>
        <h1>Sugerido</h1>
    </div>
    
    <?php
        Modal::begin([
            'title' => '<h2>Exportar a PDF</h2>',
            'headerOptions' => ['id' => 'modalHeader'],
            'id' => 'PDF',
            'size' => 'modal-sm',
            'closeButton' => [
                'id'=>'close-button',
                'class'=>'close',
                'data-dismiss' =>'modal',
            ],
            'toggleButton' => [
                'label' => 'generar pedido PDF','class' => "btn btn-success"
            ],
        ]);
    ?>

    <?=
        Html::beginForm(
        Url::toRoute("pdf"),
        'get',
        ['class'=>'form-block'])
    ?>
            <div class="form-group">
                <?='<label for="proveedor">Seleccione proveedor</label>'?>
                <?=Html::dropDownList('proveedor',$selection = null,ArrayHelper::map(product::find()->all(), "categoria","categoria"),['class'=>'form-control form-control-lg'])?>
            </div>
            <div class="form-group">
                <?=Html::submitInput('Exportar a PDF',['class' => "btn btn-info btn-lg"])?>
            </div>
    <?=
        Html::endForm(); 
    ?>
    <?php
        Modal::end();
    ?>

<?=
    GridView::widget([
    'dataProvider' =>$dataProvider,
    'filterModel' => $searchModel,
    'showPageSummary' => true,
    'showFooter'=>true,
    'columns'=>[
        //['class' => 'kartik\grid\SerialColumn'],
        [
            'label'=>'Cod',
            'value'=>function($model){
                if(isset($model['cod'])){
                    return $model['cod'];
                }else {
                    return 'S/C';
                }
            }
        ],
        [
            'attribute'=>'name',
            'label'=>'Producto'
        ],
        [
            'attribute'=>'categoria',
            'label'=>'Proveedor',
            'filter'=> $filtro = ArrayHelper::map(product::find()->where('stock < sugerido')->all(), "categoria","categoria")
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
        [
            'label'=>'Total',
            'value'=>function($model){
                $total = ($model['sugerido']-$model['stock'])*$model['precio_bolsa'];
                return $total;
            },
            'headerOptions' => ['style' => 'width:15%'],
            'mergeHeader' => true,
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
            'pageSummary' => true
            ],
        ],
    ]);?>