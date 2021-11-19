<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Product;
use yii\bootstrap4\Dropdown;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\grid\grid;

/* @var $this yii\web\View */


$this->title = 'PAgina principal';

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
                        <?= $form->field($model, 'stock')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'sugerido')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'precio_por_kg')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'precio_bolsa')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'porcentajekg')->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'porcentajebolsa')->textInput() ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        <?php
            Modal::end();
        ?>
        <?php
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
                $form = ActiveForm::begin([
                    'action'=>'venta'
                ]);
            ?>
            <?php
                ActiveForm::end();
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
                        [
                            'attribute'=>'name',
                            'label'=>'Producto'
                        ],
                        'description',
                        [
                            'attribute'=>'categoria',
                            'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria")
                        ],
                        'stock',                       
                        'sugerido',
                        [
                            'label'=>'diferencia',
                            'contentOptions'=>['color'=>grid::color( $model['sugerido'],$model['stock'])],
                            'value'=>$dif = function($model){
                                $diferencia = $model['sugerido']-$model['stock'];
                                return $diferencia;
                            },
                        ],
                        [
                            'label'=>'Precio por Kg',
                            'value'=>function($model){
                                $porcentaje = $model['porcentajekg'];
                                $precio = $model['precio_por_kg'];
                                $total = (($precio*$porcentaje)/100)+$precio;
                                return '$ '.$total;
                            },
                        ],
                        [
                            'label'=>'Precio por bolsa',
                            'value'=>function($model){
                                $porcentaje = $model['porcentajebolsa'];
                                $precio = $model['precio_bolsa'];
                                $total = (($precio*$porcentaje)/100)+$precio;
                                return '$ '.$total;
                            },
                        ],
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
                    [
                        'attribute'=>'categoria',
                        'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria")
                    ],
                    'stock',
                    'sugerido',
                    [
                        'label'=>'diferencia',
                        'value'=>function($model){
                            $diferencia = $model['sugerido']-$model['stock'];
                            
                            
                            return $diferencia;
                        },
                    ],
                    [
                        'label'=>'Precio por Kg',
                        'value'=>function($model){
                            $porcenje = ($model['precio_por_kg']*$model['porcentajekg'])/100;
                            
                            
                            return $porcenje;
                        },
                    ],
                    [
                        'label'=>'Precio por bolsa',
                        'value'=>function($model){
                            $porcenje = ($model['precio_bolsa']*$model['porcentajebolsa'])/100;
                            
                            
                            return $porcenje;
                        },
                    ]
                ],
            ]);
        }
    ?>
</div>