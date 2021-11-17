<?php
namespace app\models;
use Yii;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */


$this->title = 'My Yii Application';
?>
<div class="site-index">
    <h1>Stock de Mercaderia</h1>
    <div>
        <?php
            if (!Yii::$app->user->isGuest) {
                Modal::begin([
                    'title' => '<h2>Crear producto</h2>',
                    'headerOptions' => ['id' => 'modalHeader'],
                    'id' => 'AltaBaja',
                    'size' => 'modal-sm',
                    'closeButton' => [
                            'id'=>'close-button',
                            'class'=>'close',
                            'data-dismiss' =>'modal',
                        ],
                        'toggleButton' => [
                            'label' => 'Crear producto','class' => "btn btn-success"
                        ],
                    //keeps from closing modal with esc key or by clicking out of the modal.
                    // user must click cancel or X to close
                    'clientOptions' => [
                            'backdrop' => true, 'keyboard' => true,
                        ]
                ]);
        ?>
            <div class="product-form">
                <?php $form = ActiveForm::begin( [
                                'enableClientValidation' => true,
                                'method' => 'post',
                                ]);?>

                    <div class="form-group">
                        <?= $form->field($model, 'cod')->textInput() ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'categoria')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'status')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'precio_unidad')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'precio_bulto')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        <?php
            Modal::end();

            Modal::begin([
                'title' => '<h2>Generar venta</h2>',
                'headerOptions' => ['id' => 'modalHeader'],
                'id' => 'Venta',
                'size' => 'modal-lg',
                'closeButton' => [
                        'id'=>'close-button',
                        'class'=>'close',
                        'data-dismiss' =>'modal',
                    ],
                    'toggleButton' => [
                        'label' => 'generar venta','class' => "btn btn-success"
                    ],
                //keeps from closing modal with esc key or by clicking out of the modal.
                // user must click cancel or X to close
                'clientOptions' => [
                        'backdrop' => true, 'keyboard' => true,
                    ]
            ]);

            Modal::end();

            Modal::begin([
                'title' => '<h2>Cargar mercaderia</h2>',
                'headerOptions' => ['id' => 'modalHeader'],
                'id' => 'cargarMercaderia',
                'size' => 'modal-lg',
                'closeButton' => [
                        'id'=>'close-button',
                        'class'=>'close',
                        'data-dismiss' =>'modal',
                    ],
                    'toggleButton' => [
                        'label' => 'Cargar mercaderia','class' => "btn btn-success"
                    ],
                //keeps from closing modal with esc key or by clicking out of the modal.
                // user must click cancel or X to close
                'clientOptions' => [
                        'backdrop' => true, 'keyboard' => true,
                    ]
            ]);
            Modal::end();
        }
        ?>
        <?php
        if (!Yii::$app->user->isGuest) {
        ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns'=>[
                        'cod',
                        'name',
                        'description',
                        'categoria',
                        'status',
                        'precio_unidad',
                        'precio_bulto',
            
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Accion',
                            'headerOptions'=>[
                                                'width'=>'90'
                            ],
                            'template'=>'{update} // {delete}'
                        ],
                    ],
                ]);
            ?>
        <?php
        }else{
        ?>
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns'=>[
                    'cod',
                    'name',
                    'description',
                    'categoria',
                    'status',
                    'precio_unidad',
                    'precio_bulto',
                ],
            ]);
        }
    ?>
</div>