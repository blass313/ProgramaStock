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

    $mes = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
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
            'monto',
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
    <?=
        Highcharts::widget([
        'options' => [
            'title' => ['text' => 'Movimiento de gente'],
            'xAxis' => [
                'categories' => $fecha
            ],
                'yAxis' => [
                    'title' => ['text' => 'Cantidad']
                ],
                'series' => [
                        ['name' => $mes[1], 'data' => $montos],
                ]
            ]
        ]);
    ?>