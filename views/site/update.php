<?php
namespace app\models;
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Alert;

/* @var $this yii\web\View */


$this->title = 'Update producto';
?>

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
        <?= $form->field($model, 'stock')->textInput() ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'sugerido')->textInput() ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'kg')->textInput() ?>
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
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>