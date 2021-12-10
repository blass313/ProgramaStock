<?php
    namespace app\models;

    use yii\bootstrap4\Modal;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use miloschuman\highcharts\Highcharts;
    use kartik\date\DatePicker;
    use yii\grid\DataColumn;

    $this->title = 'facturacion';
?>
<h1>Facturacion</h1>
<h3>Total de Caja:</h3>
<?php
    Modal::begin([
        'title' => '<h2>Facturacion del dia</h2>',
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'fecha',
        'size' => 'modal-lg',
        'closeButton' => [
            'id'=>'close-button',
            'class'=>'close',
            'data-dismiss' =>'modal',
        ],
        'toggleButton' => [
            'label' => 'Ingresar facturcion','class' => "btn btn-success"
        ],
    ]);
        $form = ActiveForm::begin();?>
        <div class="form-row">
            <div class="col-6">
                <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                    'options' => ['placeholder' => 'Fecha', 'autocomplete' => "off"],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd'
                    ]
                ]); ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'ingreso')->textInput(['type' => 'number']) ?>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <?= $form->field($model, 'salida')->textInput(['type' => 'number']) ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'personas')->textInput(['type' => 'number']) ?>
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <div class="col">
                        <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>  
                </div>
            </div>
        </div>
        <?php
        ActiveForm::end();
    Modal::end();
?>
<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'showFooter'=>true,
        'columns'=>[
            [
                'attribute'=>'fecha',
                'label'=>'fecha',
                //'format' => ['date', 'php: yyyy/mm/dd'],
                'filter'=> DatePicker::widget([
                    'name' => 'fecha',
                    'type' => DatePicker::TYPE_INPUT,
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => false,
                        'format' => 'yyyy/mm/dd'
                    ],
                ]),
                'headerOptions' => ['style' => 'width:10%'],
            ],
            [
                'attribute'=>'ingreso',
                'value'=>function($model){
                    if ($model['ingreso'] != 0) {
                        return $model['ingreso'];
                    }else{
                        return 'Sin movimiento';
                    }
                }
            ],
            [
                'attribute'=>'salida',
                'value'=>function($model){
                    if ($model['salida'] != 0) {
                        return $model['salida'];
                    }else{
                        return 'Sin movimiento';
                    }
                }
            ],
            [
                'attribute' => 'personas',
                'value'=>function($model){
                    if ($model['personas'] != 0) {
                        return $model['personas'];
                    }else{
                        return 'sin ingresos';
                    }
                },
                'headerOptions' => ['style' => 'width:15%'],
                'pageSummary' => true
            ],
            [
                'label'=>'Ganancias',
                'value'=>function($model){
                    return round(($model['ingreso']*30)/100);
                }
            ],
            [
                'label'=>'caja',
                'value'=>function($model){
                    $ganancia = round(($model['ingreso']*30)/100);
                    return ($model['ingreso']-$ganancia-$model['salida']);
                },
                'headerOptions' => ['style' => 'width:10%'],
                'pageSummary' => true
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Accion',
                'headerOptions'=>[
                        'width'=>'50',
                    ],
                'template'=>'{update} // {delete}'
            ],
        ]
    ]);
?>