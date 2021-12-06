<?php
    namespace app\view;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\bootstrap4\Modal;

    use app\models\Product;
?>
    <div>
        <h1>Sugerido<?=$filtro?></h1>
    </div>
    
    <?php
        Modal::begin([
            'title' => '<h2>Crear PDf</h2>',
            'headerOptions' => ['id' => 'modalHeader'],
            'id' => 'PDF',
            'size' => 'modal-sm',
            'closeButton' => [
                'id'=>'close-button',
                'class'=>'close',
                'data-dismiss' =>'modal',
            ],
            'toggleButton' => [
                'label' => 'generar pedido PDF','class' => "btn btn-success"
            ],
        ]);
    ?>

    <?=
        Html::beginForm(
        Url::toRoute("pdf"),
        'get',
        ['class'=>'form-block'])
    ?>
            <div class="form-group">
                <?='<label for="proveedor">Seleccione proveedor</label>'?>
                <?=Html::dropDownList('proveedor',$selection = null,ArrayHelper::map(product::find()->all(), "categoria","categoria"),['class'=>'form-control form-control-lg'])?>
            </div>
            <div class="form-group">
                <?=Html::submitInput('Exportar a PDF',['class' => "btn btn-info btn-lg"])?>
            </div>
    <?=
        Html::endForm(); 
    ?>
    <?php
        Modal::end();
    ?>

<?=
    GridView::widget([
    'dataProvider' =>$dataProvider,
    'filterModel' => $searchModel,
    'columns'=>[
        [
            'label'=>'Cod',
            'value'=>function($model){
                if(isset($model['cod'])){
                    return $model['cod'];
                }else {
                    return 'Sin codigo';
                }
            }
        ],
        [
            'attribute'=>'name',
            'label'=>'Producto'
        ],
        [
            'attribute'=>'categoria',
            'label'=>'Proveedor',
            'filter'=> $filtro = ArrayHelper::map(product::find()->where('stock < sugerido')->all(), "categoria","categoria")
        ],
        [
            'attribute'=>'stock',
        ],                      
            'sugerido',
        [
            'label'=>'diferencia',
            'value'=>$dif = function($model){
                $diferencia = $model['sugerido']-$model['stock'];
                return $diferencia;
            },
        ],
        ],
    ]);?>