<?php
namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Alert;
use kartik\editable\Editable;
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
                    'format'=>'html',
                    'attribute'=>'stock',
                    'value'=>function($model){
                                if ($model['stock'] == 0) {
                                    return 'Sin Stock';
                                }else {
                                    return Html::a($model['stock'], '#');
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
                    'contentOptions' =>function($model){
                        $diferencia = $model['sugerido']-$model['stock'];
                        if ($diferencia <= 0) {
                            return ['style' => 'color: green'];
                        }else{
                            return ['style' => 'color: red'];
                        }
                    }
                ],
                [
                    'label'=>'Precio por Kg',
                    'value'=>function($model){
                            $porcentaje = $model['porcentajekg'];
                            $precio = $model['precio_bolsa'];
                            $stock = $model['kg'];
                            $total = ((($precio*$porcentaje)/100)+$precio)/$stock;

                            return round($total);
                    }
                ],
                [
                    'label'=>'Precio por bolsa',
                    'value'=>function($model){
                                $porcentaje = $model['porcentajebolsa'];
                                $precio = $model['precio_bolsa'];
                                $total = (($precio*$porcentaje)/100)+$precio;
                                return round($total);
                    },
                    'headerOptions' => ['style' => 'width:15%'],
                    'format' => ['decimal', 0],
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
        }
        ?>
</div><!--site index-->