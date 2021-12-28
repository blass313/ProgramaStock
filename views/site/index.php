<?php
    namespace app\models;

    use Yii;

    use yii\helpers\ArrayHelper;
    use yii\bootstrap4\Modal;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use yii\helpers\Url;

    use app\models\Product;

    use kartik\grid\GridView;

    /* @var $this yii\web\View */
    $this->title = 'Pagina principal';
?><!--use-->
<div class="site-index">
    <h1>Stock de Mercaderia</h1>
    <?php
        if (!Yii::$app->user->isGuest) {
    ?>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <?= Html::a('Generar PDF', ['pdf'],['class'=>'btn btn-danger btn-lg btn-block']); ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php
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
                                $form = ActiveForm::begin([
                                            'enableClientValidation' => true,
                                            "action" => Url::toRoute("site/create"),
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
                </div>
            </div>
        </div>
    <div id="tabla">
        <?php Pjax::begin() ?>
        
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'summary' => '',
                'floatHeader'=>true,
                'responsiveWrap'=>true,
                'showHeader'=> true,
                'options'=>[
                    'class' => "table table-md",
                ],
                'rowOptions' => function ($model, $index, $widget, $grid){
                    if($model->stock == 0 ){
                        return ['style' => 'background-color: rgba(255, 0, 0, 0.2)'];
                    }else {
                        return ['style' => 'background-color: rgba(0, 255, 0, 0.2)'];
                    }
            },
                'columns'=>[
                    [
                        'format'=>'html',
                        'attribute'=>'name',
                        'label'=>'Producto',
                        'width' => '15%',
                        'hAlign' => 'center',
                        'headerOptions'=>['class'=>'table-warning'],
                        'contentOptions'=>['class'=>'font-weight-bold'],
                        'options'=>['id'=>'product'],
                        'width' => '12%',
                        'filter' => true,
                    ],
                    [
                        'attribute'=>'description',
                        'filter'=>ArrayHelper::map(product::find()->all(), "description","description"),
                        'headerOptions'=>['class'=>'table-warning'],
                        'contentOptions'=>['class'=>'font-weight-bold'],
                        'width' => '10%',
                        'hAlign' => 'center',
                    ],
                    [
                        'label'=>'Kg',
                        'attribute'=>'kg',
                        'format' => ['decimal', 1],
                        'width' => '5%',
                        'hAlign' => 'right',
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                    ],
                    [
                        'attribute'=>'categoria',
                        'filter'=>ArrayHelper::map(product::find()->all(), "categoria","categoria"),
                        'hAlign' => 'center',
                        'headerOptions'=>['class'=>'table-warning'],
                        'contentOptions'=>['class'=>'font-weight-bold'],
                        'width' => '12%',
                    ],
                    [
                        'format'=>'html',
                        'attribute'=>'stock',
                        'value'=>function($model){
                                    if (empty($model['stock'])) {
                                        return 0;
                                    }else {
                                        return $model['stock'];
                                    }
                                },
                        'class'=>'kartik\grid\EditableColumn',
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'width' => '5%',
                        'hAlign' => 'right',
                        'contentOptions'=>['style'=>'font-size: 20px; font-weight: bolder;'],
                        'editableOptions'=>[
                            'header' => 'Stock', 
                            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                            'options' => [
                                'pluginOptions' => [
                                    'min' => 0, 
                                    'max' => 5000,
                                ],
                            ],
                            
                        ],
                    ],                 
                    [
                        'attribute'=>'sugerido',
                        'class'=>'kartik\grid\EditableColumn',
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'width' => '5%',
                        'hAlign' => 'right',
                        'contentOptions'=>['style'=>'font-size: 20px; font-weight: bolder;'],
                        'editableOptions'=>[
                            'header' => 'Sugerido', 
                            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                            'options' => [
                                'pluginOptions' => ['min' => 0],
                            ],
                        ]
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
                                return ['style' => 'color: green; font-size: 20px; font-weight: bolder;'];
                            }else{
                                return ['style' => 'color: red; font-size: 20px; font-weight: bolder;'];
                            }
                        },
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'mergeHeader' => true,
                        'width' => '5%',
                        'hAlign' => 'right',
                    ],
                    [
                        'attribute'=>'precio_bolsa',
                        'width' => '12%',
                        'class'=>'kartik\grid\EditableColumn',
                        'hAlign' => 'right',
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'contentOptions'=>['style'=>'font-size: 20px'],
                        'format' => ['decimal', 1], 
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
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'width' => '12%',
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        'contentOptions'=>['style'=>'font-size: 20px'],
                    ],
                    [
                        'label'=>'Precio por bolsa',
                        'value'=>function($model){
                                    $porcentaje = $model['porcentajebolsa'];
                                    $precio = $model['precio_bolsa'];
                                    $total = (($precio*$porcentaje)/100)+$precio;
                                    return round($total);
                        },
                        'headerOptions'=>['class'=>'table-warning'],
                        'mergeHeader' => true,
                        'width' => '12%',
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        'contentOptions'=>['style'=>'font-size: 20px'],
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'headerOptions'=>['class'=>'table-warning'],
                    ]
                ],
            ]);
        ?>
        <?php Pjax::end() ?>
    </div>
    <?php
        }
        ?>
</div><!--site index-->
