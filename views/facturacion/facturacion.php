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

    use app\models\Facturacion;

    $this->title = 'facturacion'
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
        'label' => 'Cargar mercaderia','class' => "btn btn-success"
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
                    <?= $form->field($model, 'monto')->textInput() ?>
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
            'monto'
        ],
    ]);
?>
                    <?=
                        Highcharts::widget([
                        'options' => [
                            'fill'=>['black'],
                            'title' => ['text' => 'Movimiento de gente'],
                            'xAxis' => [
                                'categories' => [
                                ]
                            ],
                            'yAxis' => [
                                'title' => ['text' => 'Cantidad']
                            ],
                            'series' => [
                                ['name' => 'enero', 'data' => []],
                            ]
                        ]
                        ]);
                    ?>