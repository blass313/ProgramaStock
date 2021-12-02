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

use app\models\Product;

/* @var $this yii\web\View */


$this->title = 'Pagina principal';
?><!--use-->

<div class="site-index">
    <h1>Stock de Mercaderia</h1>
    <?php
        if (!Yii::$app->user->isGuest) {
            Modal::begin([
                'title' => '<h2>Crear producto</h2>',
                'headerOptions' => ['id' => 'modalHeader'],
                'id' => 'AltaBaja',
                'size' => 'modal-lg',
                'closeButton' => [
                    'id'=>'close-button',
                    'class'=>'close',
                    'data-dismiss' =>'modal',
                ],
                'toggleButton' => [
                    'label' => 'Crear producto','class' => "btn btn-success"
                ],
                'clientOptions' => [
                    'backdrop' => true, 'keyboard' => true,
                ]
            ]);
    ?><!--Modal-->

        <div class="product-form">
            <?php 
                $form = ActiveForm::begin( [
                            'enableClientValidation' => true,
                            'method' => 'post',
                            ]);
            ?>

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'cod')->textInput() ?>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div><!--form row-->

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'categoria')->textInput() ?>
                    </div>
                </div>
            </div><!--form row-->

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'stock')->textInput() ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'sugerido')->textInput() ?>
                    </div>
                </div>
            </div><!--form row-->

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'kg')->textInput() ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'precio_bolsa')->textInput() ?>
                    </div>
                </div>
            </div><!--form row-->

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'porcentajekg')->textInput() ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'porcentajebolsa')->textInput() ?>
                    </div>
                </div>
            </div><!--form row-->

            <div class="form-group">
                <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
            </div>
            <?php 
                ActiveForm::end(); 
            ?>
        </div><!--product-form-->

    <?php
        Modal::end();
    ?>

    <?php
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
        ]);
    ?>

    <?=
        Html::beginForm(
        Url::toRoute("site/mercaderia"),
        'get',
        ['class'=>'form-block'])
    ?>
        <div class="form-row">
            <div class="col-4">
                <div class="form-group">
                    <?=Html::dropDownList('producto',$selection = null,ArrayHelper::map(product::find()->all(), "cod","name"))?>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <?=Html::textInput('stock')?>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <?=Html::submitInput('Cargar stock',['class' => "btn btn-success"])?>
                </div>
            </div>
        </div><!--form row-->
    <?=
        Html::endForm(); 
    ?>
    <?php
        Modal::end();
    ?>
    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'=>[
                //'cod',
                [
                    'attribute'=>'name',
                    'label'=>'Producto'
                ],
                    'description',
                [
                    'label'=>'Kg',
                    'attribute'=>'kg',
                ],
                [
                    'attribute'=>'categoria',
                    'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria")
                ],
                [
                    'attribute'=>'stock',
                    'value'=>function($model){
                                if ($model['stock'] == 0) {
                                    return 'Sin Stock';
                                }else {
                                    return $model['stock'];
                                }
                            }
                ],                 
                'sugerido',
                [
                    'label'=>'diferencia',
                    'value'=>$dif = function($model){
                                        $diferencia = $model['sugerido']-$model['stock'];
                                        return $diferencia;
                                    },
                ],
                [
                    'label'=>'Precio por Kg',
                    'value'=>function($model){
                            $porcentaje = $model['porcentajekg'];
                            $precio = $model['precio_bolsa'];
                            $stock = $model['kg'];
                            $total = ((($precio*$porcentaje)/100)+$precio)/$stock;

                            return '$ '.round($total);
                    }
                ],
                [
                    'label'=>'Precio por bolsa',
                    'value'=>function($model){
                                $porcentaje = $model['porcentajebolsa'];
                                $precio = $model['precio_bolsa'];
                                $total = (($precio*$porcentaje)/100)+$precio;
                                return '$ '.round($total);
                    }
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
                    //'cod',
                    [
                        'attribute'=>'name',
                        'label'=>'Producto'
                    ],
                        'description',
                    [
                        'label'=>'Kg',
                        'attribute'=>'kg',
                    ],
                    [
                        'attribute'=>'categoria',
                        'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria")
                    ],
                    [
                        'attribute'=>'stock',
                        'value'=>function($model){
                                    if ($model['stock'] == 0) {
                                        return 'Sin Stock';
                                    }else {
                                        return $model['stock'];
                                    }
                                }
                    ],                 
                    'sugerido',
                    [
                        'label'=>'diferencia',
                        'value'=>$dif = function($model){
                                            $diferencia = $model['sugerido']-$model['stock'];
                                            return $diferencia;
                                        },
                    ],
                    [
                        'label'=>'Precio por Kg',
                        'value'=>function($model){
                                $porcentaje = $model['porcentajekg'];
                                $precio = $model['precio_bolsa'];
                                $stock = $model['kg'];
                                $total = ((($precio*$porcentaje)/100)+$precio)/$stock;
    
                                return '$ '.round($total);
                        }
                    ],
                    [
                        'label'=>'Precio por bolsa',
                        'value'=>function($model){
                                    $porcentaje = $model['porcentajebolsa'];
                                    $precio = $model['precio_bolsa'];
                                    $total = (($precio*$porcentaje)/100)+$precio;
                                    return '$ '.round($total);
                        }
                    ],
                ]
            ]);
        }
        ?>
</div><!--site index-->