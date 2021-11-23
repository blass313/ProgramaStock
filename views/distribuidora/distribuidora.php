<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\bootstrap4\Modal;

    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;
?>

<?php
    Modal::begin([
        'title'=>'<h2>Cargar boleta</h2>',
        'headerOptions'=>['id'=>'modalHeader'],
        'id'=>'CargarBoleta',
        'size'=>'modal-lg',
        'closeButton'=>[
            'id'=>'close-button',
            'class'=>'close',
            'data-dismiss'=>'modal'
        ],
        'toggleButton'=>[
            'label'=>'Cargar Boleta',
            'class'=>'btn btn-success'
        ]
        ]);
?>
    <?php
        $form = ActiveForm::begin([
            'enableClientValidation'=>true,
            'method'=>'post'
        ]);
    ?>
    
        <div class="form-row">
            <div class="col-6">
                <?= $form->field($model, 'fecha_de_factura')->textInput() ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'numero_boleta')->textInput() ?>
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'nombre_distribuidora')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'monto')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'estado')->dropDownList([ 'impaga' => 'impaga', 'pagada' => 'pagada'], ['prompt' => 'Seleccione Uno' ]);?>
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
        ActiveForm::end()
    ?>
<?php    
    Modal::end();
?>
<?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'=>[
            ],
        ]);
?>