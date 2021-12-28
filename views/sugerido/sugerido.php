<?php
    namespace app\view;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\bootstrap4\Modal;
    use kartik\dynagrid\DynaGrid;

    use app\models\Product;
?>
    <div>
        <h1>Sugerido</h1>
    </div>
    <div class="form-group">
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
                'label' => 'generar pedido PDF','class' => "btn btn-danger"
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
                <?=Html::dropDownList('proveedor',$selection = null,ArrayHelper::map(product::find()->where('stock < sugerido')->all(), "categoria","categoria"),['class'=>'form-control form-control-lg'])?>
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
    </div>
<div id="tabla">

<?=
    GridView::widget([
    'dataProvider' =>$dataProvider,
    'filterModel' => $searchModel,
    'pageSummaryPosition'=>GridView::POS_TOP,
    'summary' => '',
    'showPageSummary' => true,
    'floatHeader'=>true,
    'showHeader'=>true,
    'columns'=>[
        [
            'attribute'=>'name',
            'label'=>'Producto',
            'headerOptions' => ['style' => 'width:15%'],
            'width' => '120px',
            'hAlign' => 'center',
            'pageSummary'=>'Monto Total',
        ],
        [
            'attribute'=>'description',
            'label'=>'Descripcion',
            'headerOptions' => ['style' => 'width:15%'],
            'width' => '120px',
            'hAlign' => 'center',
        ],
        [
            'attribute'=>'categoria',
            'label'=>'Proveedor',
            'filter'=> $filtro = ArrayHelper::map(product::find()->where('stock < sugerido')->all(), "categoria","categoria"),
            'headerOptions' => ['style' => 'width:15%'],
            'width' => '120px',
            'hAlign' => 'center',
        ],
        [
            'label'=>'diferencia',
            'value'=>$dif = function($model){
                $diferencia = $model['sugerido']-$model['stock'];
                return $diferencia;
            },
            'headerOptions' => ['style' => 'width:15%'],
            'mergeHeader' => true,
            'width' => '100px',
            'hAlign' => 'center',
            
            'contentOptions'=>['class'=>'font-weight-bold'],
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
        ['class'=>'kartik\grid\CheckboxColumn'],
    ],
    ]);?>
</div>