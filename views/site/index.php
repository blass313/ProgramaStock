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
                'size' => 'modal-lg',
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
            </div>

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
            </div>

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
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'precio_por_kg')->textInput() ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= $form->field($model, 'precio_bolsa')->textInput() ?>
                    </div>
                </div>
            </div>

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
                ]);?>
                <?=Html::beginForm(
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
            </div>
                <?=Html::endForm();?>
                <?php
            Modal::end();?>

            <?php
            Modal::begin([
                'title' => '<h2>Movimiento de gente</h2>',
                'headerOptions' => ['id' => 'movimientoGente','background'=>'black'],
                'id' => 'movimientoGente',
                'size' => 'modal-xl',
                'closeButton' => [
                    'id'=>'close-button',
                    'class'=>'close',
                    'data-dismiss' =>'modal',
                ],
                'toggleButton' => [
                'label' => 'Movimiento de gente','class' => "btn btn-success"
                ],
                ]);?>
                    <?=
                        Highcharts::widget([
                        'options' => [
                            'fill'=>['black'],
                            'title' => ['text' => 'Movimiento de gente'],
                            'xAxis' => [
                                'categories' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
                            ],
                            'yAxis' => [
                                'title' => ['text' => 'Cantidad']
                            ],
                            'series' => [
                                ['name' => 'enero', 'data' => [50, 60, 35,22, 68, 35, 33, 28, 32,55, 23, 100,33, 25, 33,66 , 20, 35,50, 20, 35,50, 20, 35,50, 20, 35,50, 20, 35]],
                                ['name' => 'febrero', 'data' => [38,22,56,88,78,52,56,96,58,47,52,100,25,68,33,44,78,55,68,96,36,58,45,22,68,33,68,57,85,28,52]],
                                ['name' => 'marzo', 'data' => [28,74,85,96,87,85,25,35,48,78,75,77,28,25,100,23,38,78,63,28,75,25,48,25,18,96,38,56,23,48,85]],
                                ['name' => 'abril', 'data' => [5,25,78,79,69,85,22,36,58,78,99,100,108,33,68,78,58,48,96,25,7,89,11,22,38,78,99,44,56,78,22]],
                                ['name' => 'mayo', 'data' => [38,75,96,28,74,22,35,12,25,36,89,36,58,78,96,58,74,89,34,56,78,67,54,66,78,23,45,67,44,56,78,33]],
                                ['name' => 'junio', 'data' => [33,78,96,58,11,25,78,96,25,87,26,36,78,58,75,96,0,59,66,85,78,52,36,58,75,25,36,52,15,87,125,78]],
                                ['name' => 'julio', 'data' => [36,58,78,52,21,14,78,58,96,58,74,25,41,23,65,85,42,15,36,58,7,52,17,0,25,0,147,85,35,89,36,25]],
                                ['name' => 'agosto', 'data' => 68,23,78,96,11,23,68,55,72,15,36,98,75,89,36,58,75,14,36,58,78,96,58,78,25,87,2,14,78,56,98,77],
                                ['name' => 'septiembre', 'data' => [66,87,8,96,58,7,0,25,78,25,69,8,75,33,31,48,7,89,25,78,96,25,78,54,14,79,36,58,74,21,58,78]],
                                ['name' => 'octubre', 'data' => [36,36,87,96,25,87,89,36,14,25,87,2,36,0,14,78,0,36,89,69,87,25,36,47,89,69,87,12,36,98,74,25]],
                            ]
                        ]
                        ]);
                    ?>
                <?php
            Modal::end();
    }//isGuest
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
                    [
                        'attribute'=>'stock',
                        'value'=>function($model){
                            if ($model['stock'] == 0) {
                                return 'Sin Stock';
                            }else {
                                return $model['stock'];
                            }
                        }
                    ],/*                   
                    'sugerido',
                    [
                        'label'=>'diferencia',
                        'value'=>$dif = function($model){
                        $diferencia = $model['sugerido']-$model['stock'];
                        return $diferencia;
                        },
                    ],*/
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
                /*
                'sugerido',
                [
                    'label'=>'diferencia',
                    'value'=>function($model){
                    $diferencia = $model['sugerido']-$model['stock'];


                    return $diferencia;
                    },
                ],*/
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