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
                    'label' => 'generar pedido PDF','class' => "btn btn-success btn-lg btn-block"
                ],
            ]);
        ?>

        <?=
            Html::beginForm(
            Url::toRoute("sugeridopdf"),
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

    <?=
        Html::beginForm(
        Url::toRoute("checkbox"),
        'post',
        ['class'=>'form-block'])
    ?>
        <div>
            <?=html::submitInput('generar pfd con filtro',['class' => "btn btn-info btn-lg btn-block"])?>
        </div>
        <?=
            GridView::widget([
            'dataProvider' =>$dataSugerido,
            'filterModel' => $searchSugeridoModel,
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
                    'filter'=>ArrayHelper::map(product::find()->where('stock < sugerido')->all(), "categoria","categoria"),
                    'headerOptions' => ['style' => 'width:15%'],
                    'width' => '120px',
                    'hAlign' => 'center',
                ],
                [
                    'label'=>'diferencia',
                    'value'=>function($modelSugerido){
                        $diferencia = $modelSugerido['sugerido']-$modelSugerido['stock'];
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
                    'value'=>function($modelSugerido){
                        $total = ($modelSugerido['sugerido']-$modelSugerido['stock'])*$modelSugerido['precio_bolsa'];
                        return $total;
                    },
                    'headerOptions' => ['style' => 'width:15%'],
                    'mergeHeader' => true,
                    'width' => '150px',
                    'hAlign' => 'right',
                    'format' => ['decimal', 2],
                    'pageSummary' => true
                ],
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'content' => function($model) {
                        return Html::checkBox ('selection[]',false,['value'=>"$model->id",'class' => 'status-control-input']);
                    } ,
                ],
            ],
            ]);
        ?>
    <?=
        Html::endForm(); 
    ?>
</div>