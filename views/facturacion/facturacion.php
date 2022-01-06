<?php
    namespace app\models;

    use yii\bootstrap4\Modal;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;
    
    use yii\helpers\Url;

    $this->title = 'facturacion';
?>
<h1>Facturacion por dia</h1>
<div>
    <div class="form-row">
        <div class="col-4">
            <div class="form-group">
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
                            'label' => 'Ingresar facturacion','class'=>'btn btn-danger btn-lg btn-block'
                        ],
                    ]);
                ?>
                    <?php
                        $form = ActiveForm::begin([
                            "action" => Url::toRoute("facturacion/create"),
                            'method' => 'post',
                        ]);
                    ?>
                    <div class="form-row">
                        <div class="col-6">
                            <?= $form->field($modelFacturacion, 'fecha')->widget(DatePicker::class, [
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
                            <?= $form->field($modelFacturacion, 'ingreso')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <?= $form->field($modelFacturacion, 'salida')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($modelFacturacion, 'personas')->textInput(['type' => 'number']) ?>
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
                    ?>
                <?php
                    Modal::end();
                ?>
            </div>
        </div>
    </div><!--form row-->
</div>

<div>
    <?=
        GridView::widget([
            'dataProvider' => $dataFacturacion,
            'filterModel' => $searchFacturacionModel,
            'summary' => '',
            'floatHeader'=>true,
            'pageSummaryPosition'=>GridView::POS_TOP,
            'showPageSummary' => true,
            'floatHeader' => true,
            'columns'=>[
                [
                    'class'=>'kartik\grid\SerialColumn',
                    'contentOptions'=>['class'=>'kartik-sheet-style'],
                    'width'=>'36px',
                    'pageSummary'=>'Total',
                    'pageSummaryOptions' => ['colspan' => 2],
                    'header'=>'',
                    'headerOptions' => ['class' => 'table-info'],
                ],
                [
                    'attribute'=>'fecha',
                    'label'=>'fecha',
                    'filter' => DatePicker::widget([
                        'model'=>$searchFacturacionModel,
                        'attribute'=>'fecha',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy/mm/dd',
                            'autocomplete'=>'off'
                        ]
                    ]),
                    'format' => 'html',
                    'headerOptions' => ['class' => 'table-info'],
                ],
                [
                    'attribute'=>'ingreso',
                    'value'=>function($modelFacturacion){
                        if ($modelFacturacion['ingreso'] != 0) {
                            return $modelFacturacion['ingreso'];
                        }else{
                            return 0;
                        } 
                    },
                    'pageSummary' => true,
                    'hAlign' => 'right',
                    'format'=>['decimal',2],
                    'headerOptions' => ['class' => 'table-info'],
                ],
                [
                    'attribute'=>'salida',
                    'value'=>function($modelFacturacion){
                        if ($modelFacturacion['salida'] != 0) {
                            return $modelFacturacion['salida'];
                        }else{
                            return 0;
                        }
                    },
                    'pageSummary' => true,
                    'hAlign' => 'right',
                    'format'=>['decimal',2],
                    'headerOptions' => ['class' => 'table-info'],
                    'mergeHeader' => true,
                ],
                [
                    'attribute' => 'personas',
                    'value'=>function($modelFacturacion){
                        if ($modelFacturacion['personas'] != 0) {
                            return $modelFacturacion['personas'];
                        }else{
                            return 0;
                        }
                    },
                    'headerOptions' => ['style' => 'width:15%'],
                    'pageSummary' => true,
                    'hAlign' => 'right',
                    'format'=>['decimal',0],
                    'headerOptions' => ['class' => 'table-info'],
                    //'mergeHeader' => true,
                ],
                [
                    'label'=>'Ganancias',
                    'value'=>function($modelFacturacion){
                        return round(($modelFacturacion['ingreso']*30)/100);
                    },
                    'pageSummary' => true,
                    'hAlign' => 'right',
                    'format'=>['decimal',2],
                    'headerOptions' => ['class' => 'table-info'],
                    'mergeHeader' => true,
                ],
                [
                    'label'=>'caja',
                    'value'=>function($modelFacturacion){
                        $ganancia = round(($modelFacturacion['ingreso']*30)/100);
                        return ($modelFacturacion['ingreso']-$ganancia-$modelFacturacion['salida']);
                    },
                    'headerOptions' => ['class' => 'table-info'],
                    'pageSummary' => true,
                    'hAlign' => 'right',
                    'format'=>['decimal',2],
                    'mergeHeader' => true,
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'headerOptions'=>['class'=>'table-info'],
                ]
            ]
        ]);
    ?>
</div>