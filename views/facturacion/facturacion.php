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
        'columns'=>[
            'fecha',
            'ingreso',
            'salida',
            'personas',
            [
                'label'=>'Ganancias',
                'value'=>function($model){
                    return round(($model['ingreso']*30)/100);
                }
            ],
            [
                'label'=>'caja',
                'value'=>function($model){
                    return round(((($model['salida']-(round(($model['ingreso']*30)/100))))*30)/100);
                }
            ]
        ]
    ]);
?>