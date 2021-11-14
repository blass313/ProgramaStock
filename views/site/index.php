<?php
namespace app\models;

use yii\helpers\Url;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\base\Model;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */


$this->title = 'My Yii Application';
?>
<div class="site-index">
    <h1>Stock de Mercaderia</h1>
    <div>
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
                        'label' => 'Crear producto','class' => "btn btn-success"
                    ],
                //keeps from closing modal with esc key or by clicking out of the modal.
                // user must click cancel or X to close
                'clientOptions' => [
                        'backdrop' => true, 'keyboard' => true,
                    ]
            ]);?>

            <div class="product-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'cod')->textInput() ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

                <?= $form->field($model, 'categoria')->textInput() ?>

                <?= $form->field($model, 'status')->textInput() ?>

                <?= $form->field($model, 'precio_unidad')->textInput() ?>

                <?= $form->field($model, 'precio_bulto')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        <?php
            Modal::end();
        ?>
    </div>
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
    
                ['class' => 'yii\grid\ActionColumn'],                
            ]
        ])
    ?>
</div>
