<?php
    namespace app\models;

    use Yii;

    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use yii\bootstrap4\Modal;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use miloschuman\highcharts\Highcharts;
    use yii\grid\ActionColumn;

    use app\models\Facturacion;

    $this->title = 'facturacion';
?>

<?php
    Modal::begin([
        'title'=> '<h2>Facturacion</h2>',
        'headerOptions'=>['id'=>'modalHeader'],
        'id'=> 'Facturacion',
        'size' => 'modal-lg',
        'closeButton' => [
            'id'=>'close-button',
            'class'=>'close',
            'data-dismiss' =>'modal',
        ],
        'toggleButton' => [
        'label' => 'Ingreso del dia','class' => "btn btn-success"
        ],
    ]);//model::begin
        $form = ActiveForm::begin();?>
        <div class="form-row">
            <div class="col-6">
                <?= $form->field($model, 'fecha')->textInput() ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'tipo')->dropDownList(['ingreso'=>'ingreso','salida'=>'salida']) ?>
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'monto')->textInput(['type' => 'number']) ?>
                </div>
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
        'columns'=>[
            'fecha',
            'tipo',
            [
                'attribute'=>'monto',
                'label'=>'Monto neto'
            ],
            [
                'label'=>'Ganancia del %30',
                'value'=>function($model){
                    $ganancia = null;
                    $ganancia = ($model['monto']*30)/100;
                    $MontoGanancia = ($model['tipo'] == 'ingreso') ? $ganancia = "$ ".($model['monto']*30)/100: $ganancia = "";
                    return $MontoGanancia;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Accion',
                'headerOptions'=>[
                'width'=>'90'
            ],
                'template'=>'{delete}'
            ],
        ],

    ]);
?>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
                <?=
                Highcharts::widget([
                'options' => [
                    'chart'=>[ 
                        'type'=> 'column'
                    ],
                    'title' => ['text' => 'Facturacion del dia(Ingreso)'],
                    'xAxis' => [
                        'categories' => $fechaIngreso,
                    ],
                        'yAxis' => [
                            'title' => ['text' => 'Cantidad']
                        ],
                        'series' => [
                                [
                                    'name' => 'Ingreso', 
                                    'data' => $montosIngreso,
                                    'color'=>'green'
                                ],
                        ]
                    ]
                ]);
            ?>
        </div>
        <div class="carousel-item">
            <?=
            Highcharts::widget([
            'options' => [
                'chart'=>[ 
                    'type'=> 'column'
                ],
                'title' => ['text' => 'Facturacion del dia(Salida)'],
                'xAxis' => [
                    'categories' => $fechaSalida,
                    'title' => ['text' => 'Fecha']
                ],
                    'yAxis' => [
                        'title' => ['text' => 'Cantidad']
                    ],
                    'series' => [
                            [
                                'name' => 'Gasto',
                                'data' => $montoSalida,
                                'color'=>'red'
                            ],
                            //['name' => 'Ganancia', 'data' => ()],
                    ]
                ]
            ]);
        ?>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>