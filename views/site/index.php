<?php
namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Product;

/* @var $this yii\web\View */
$this->title = 'Pagina principal';
?><!--use-->
<div class="site-index">
    <h1>Stock de Mercaderia</h1>
    <?php
        if (!Yii::$app->user->isGuest) {
            echo Html::a('Generar PDF', ['pdf'],['class'=>'btn btn-danger btn-lg btn-block']);
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
                    'label' => 'Crear producto','class' => "btn btn-success btn-lg btn-block"
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
            'pjax'=>true,
            'rowOptions' => function ($model, $index, $widget, $grid){
                if($model->stock == 0){
                    return ['style' => 'background-color: rgba(255, 0, 0, 0.2)'];
                }else {
                    return ['style' => 'background-color: rgba(0, 255, 0, 0.2)'];
                }
          },
            'columns'=>[
                [
                    'class'=>'kartik\grid\SerialColumn',
                    'contentOptions'=>['class'=>'kartik-sheet-style'],
                    'width'=>'36px',
                    'pageSummary'=>'Total',
                    'pageSummaryOptions' => ['colspan' => 6],
                    'header'=>'',
                    'headerOptions'=>['class'=>'kartik-sheet-style']
                ],
                //'cod',
                [
                    'attribute'=>'name',
                    'label'=>'Producto',
                    'width' => '130px',
                    'hAlign' => 'center',
                ],
                [
                    'attribute'=>'description',
                    'headerOptions' => ['style' => 'width:15%'],
                    'width' => '100px',
                    'hAlign' => 'center',
                ],
                [
                    'label'=>'Kg',
                    'attribute'=>'kg',
                    'format' => ['decimal', 1],
                    'width' => '100px',
                    'hAlign' => 'center',
                ],
                [
                    'attribute'=>'categoria',
                    'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria"),
                    'hAlign' => 'center',
                ],
                [

                    'format'=>'html',
                    'attribute'=>'stock',
                    'value'=>function($model){
                                if ($model['stock'] == 0 || $model['stock'] == null) {
                                    return '-';
                                }else {
                                    return $model['stock'];
                                }
                            },
                    'class'=>'kartik\grid\EditableColumn',
                    'headerOptions' => ['style' => 'width:15%'],
                    'mergeHeader' => true,
                    'width' => '50px',
                    'hAlign' => 'center',
                ],                 
                [
                    'attribute'=>'sugerido',
                    'class'=>'kartik\grid\EditableColumn',
                    'headerOptions' => ['style' => 'width:15%'],
                    'mergeHeader' => true,
                    'width' => '50px',
                    'hAlign' => 'center',
                ],
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
                    },
                    'headerOptions' => ['style' => 'width:15%'],
                    'mergeHeader' => true,
                    'width' => '30px',
                    'hAlign' => 'center',
                ],
                [
                    'label'=>'Precio por Kg',
                    'value'=>function($model){
                            $porcentaje = $model['porcentajekg'];
                            $precio = $model['precio_bolsa'];
                            $stock = $model['kg'];
                            if ($porcentaje != 0) {
                                if ($stock != 0) {
                                    $total = ((($precio*$porcentaje)/100)+$precio)/$stock;
    
                                    return round($total);
                                }else{
                                    $total = 0;
                                    return $total;
                                }
                            }else {
                                $total = 0;
                                return $total;
                            }
                    },
                    'headerOptions' => ['style' => 'width:15%'],
                    'mergeHeader' => true,
                    'width' => '30px',
                    'hAlign' => 'right',
                    'format' => ['decimal', 2],
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
                    'mergeHeader' => true,
                    'width' => '30px',
                    'hAlign' => 'right',
                    'format' => ['decimal', 2],
                ],
                [
                    
                    'class' => '\yii\grid\ActionColumn',
                    'header'=> 'Accion',
                    'headerOptions'=>[
                            'width'=>'90'
                        ],
                    'template'=>'{update}  {delete}',
                ],
            ],
        ]);
    ?>
    <?php
        }
        ?>
</div><!--site index-->