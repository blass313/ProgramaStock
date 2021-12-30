<?php
    namespace app\models;

    use yii\bootstrap4\Modal;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;
    use yii\widgets\Pjax;
    use kartik\daterange\DateRangePicker;
    use yii\helpers\Url;

    $this->title = 'facturacion';
?>
<h1>Facturacion</h1>
<div>
<?php 
                            $fechas = ActiveForm::begin([
                                "method" => "get",
                                'id' => 'busquedaFecha',
                                "enableClientValidation" => true,
                            ]);
                        ?>
                        <div class="form-row">
                            <div class="col-6">
                                    <?= 
                                        $fechas->field($formFecha, 'fechaDesde')->widget(DatePicker::class, [
                                            'options' => [
                                                'placeholder' => 'Fecha desde', 
                                                'autocomplete' => "off",
                                                'id'=>'desde'
                                            ],
                                            'type' => DatePicker::TYPE_INPUT,
                                            'pluginOptions' => [
                                            'autoclose' => true,
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy/mm/dd'
                                            ]
                                        ]);
                                    ?>
                            </div>
                            <div class="col-6">
                                <?= 
                                    $fechas->field($formFecha, 'fechaHasta')->widget(DatePicker::class, [
                                        'options' => [
                                            'placeholder' => 'Fecha hasta', 
                                            'autocomplete' => "off",
                                            'id'=>'hasta'
                                        ],
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy/mm/dd'
                                        ]
                                    ]);
                                ?>
                            </div>
                            <?= Html::submitButton("Buscar", ["class" => "btn btn-primary", "id"=>"buscar"]);?>
                        </div><!--form row-->
                        <?php 
                            ActiveForm::end();
                        ?>
                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>Fecha</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Personas</th>
                                <th>ganancia</th>
                                <th>caja</th>
                            </tr>
                            <?php
                                foreach($rows as $row):
                            ?>
                                <tr>
                                    <td><?=$row['fecha'];?></td>
                                    <td><?=$row['ingreso']?></td>
                                    <td><?=$row['salida']?></td>
                                    <td><?=$row['personas']?></td>
                                    <td><?=number_format(round(($row['ingreso']*30)/100), 2, '.', ','); ?></td>
                                    <td><?=number_format($row['ingreso']-round(($row['ingreso']*30)/100)-$row['salida'], 2, '.', ',');?></td>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </table>
</div>
    <div class="form-row">
        <div class="col-6">
            <div class="form-group">
                <?php
                    Modal::begin([
                        'title' => '<h2>Facturacion por mes</h2>',
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'Mes',
                        'size' => 'modal-xl',
                        'closeButton' => [
                            'id'=>'close-button',
                            'class'=>'close',
                            'data-dismiss' =>'modal',
                        ],
                        'toggleButton' => [
                            'label' => 'Movimientos por rango','class'=>'btn btn-info btn-lg btn-block'
                        ],
                    ]);
                ?>
                        <?php 
                            $fechas = ActiveForm::begin([
                                "method" => "get",
                                'id' => 'busquedaFecha',
                                "enableClientValidation" => true,
                            ]);
                        ?>
                        <div class="form-row">
                            <div class="col-6">
                                    <?= 
                                        $fechas->field($formFecha, 'fechaDesde')->widget(DatePicker::class, [
                                            'options' => [
                                                'placeholder' => 'Fecha desde', 
                                                'autocomplete' => "off",
                                                'id'=>'desde'
                                            ],
                                            'type' => DatePicker::TYPE_INPUT,
                                            'pluginOptions' => [
                                            'autoclose' => true,
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy/mm/dd'
                                            ]
                                        ]);
                                    ?>
                            </div>
                            <div class="col-6">
                                <?= 
                                    $fechas->field($formFecha, 'fechaHasta')->widget(DatePicker::class, [
                                        'options' => [
                                            'placeholder' => 'Fecha hasta', 
                                            'autocomplete' => "off",
                                            'id'=>'hasta'
                                        ],
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy/mm/dd'
                                        ]
                                    ]);
                                ?>
                            </div>
                            <?= Html::submitButton("Buscar", ["class" => "btn btn-primary", "id"=>"buscar"]) ?>
                        </div><!--form row-->
                        <?php 
                            ActiveForm::end();
                        ?>
                    <div>
                    <table class="table table-hover">
                            <tr>
                                <th>Fecha</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Personas</th>
                                <th>ganancia</th>
                                <th>caja</th>
                            </tr>
                            <?php
                                foreach($rows as $row):
                            ?>
                                <tr>
                                    <td><?=$row['fecha'];?></td>
                                    <td><?=$row['ingreso']?></td>
                                    <td><?=$row['salida']?></td>
                                    <td><?=$row['personas']?></td>
                                    <td><?=number_format(round(($row['ingreso']*30)/100), 2, '.', ','); ?></td>
                                    <td><?=number_format($row['ingreso']-round(($row['ingreso']*30)/100)-$row['salida'], 2, '.', ',');?></td>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </table>
                    </div>
                <?php
                    Modal::end();
                ?>
            </div>
        </div>

        <div class="col-6">
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
                        $form = ActiveForm::begin();
                    ?>
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
                    ?>
                <?php
                    Modal::end();
                ?>
            </div>
        </div>
    </div><!--form row-->

<div id="tabla">
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
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
                            'model'=>$searchModel,
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
                        'value'=>function($model){
                            if ($model['ingreso'] != 0) {
                                return $model['ingreso'];
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
                        'value'=>function($model){
                            if ($model['salida'] != 0) {
                                return $model['salida'];
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
                        'value'=>function($model){
                            if ($model['personas'] != 0) {
                                return $model['personas'];
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
                        'value'=>function($model){
                            return round(($model['ingreso']*30)/100);
                        },
                        'pageSummary' => true,
                        'hAlign' => 'right',
                        'format'=>['decimal',2],
                        'headerOptions' => ['class' => 'table-info'],
                        'mergeHeader' => true,
                    ],
                    [
                        'label'=>'caja',
                        'value'=>function($model){
                            $ganancia = round(($model['ingreso']*30)/100);
                            return ($model['ingreso']-$ganancia-$model['salida']);
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