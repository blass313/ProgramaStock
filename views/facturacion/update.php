<?php
namespace app\models;
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */


$this->title = 'Update';
?>
<?php 
       $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'method' => 'post',
       ]);?>
       <div class="form-row">
           <div class="col-6">
               <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                   'options' => ['placeholder' => 'Fecha', 'autocomplete' => "off"],
                   'type' => DatePicker::TYPE_INPUT,
                   'pluginOptions' => [
                       'autoclose' => true,
                   ],
                   'pluginOptions' => [
                       'autoclose' => true,
                       'format' => 'yyyy/mm/dd'
                   ]
               ]); ?>
           </div>
           <div class="col-6">
               <?= $form->field($model, 'ingreso')->textInput(['type' => 'number']) ?>
           </div>
       </div>
       <div class="form-row">
           <div class="col">
               <?= $form->field($model, 'salida')->textInput(['type' => 'number']) ?>
           </div>
           <div class="col-6">
               <?= $form->field($model, 'personas')->textInput(['type' => 'number']) ?>
           </div>
       </div>
       <div class="form-row">
           <div class="row">
               <div class="col">
                       <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>  
               </div>
           </div>
       </div>
       <?php
       ActiveForm::end();