<?php
namespace app\models;
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */


$this->title = 'Update producto';
?>
<h3><?= $msg ?></h3>
<?php 
    $form = ActiveForm::begin( [
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
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>