<?php
    namespace app\models;

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;

    $this->title = 'Resumen por meses';
?>
<?php
    $año = ActiveForm::begin([
        "method" => "get",
        'id' => 'Meses',
        "enableClientValidation" => true,
    ]);
?>
        <div class="form-row">
            <div class="col-4">
                <?= 
                    $año->field($model2,'año')->textInput([
                        'type' => 'number',
                        'min' => 2018
                   ])->label(false);
                ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton("Seleccionar año", ["class" => "btn btn-primary", "id"=>"año"]);?>
            </div>
        </div><!--form row-->      
<?php 
    ActiveForm::end();
?>


<table class="table" id="tabla" style="height:200px; overflow:scroll;">
    <thead class="thead-dark">
        <tr style="position: sticky; top: 0; z-index: 10; background-color: #ffffff;">
            <th class="header" scope="col">mes</th>
            <th class="header" scope="col">año</th>
            <th class="header" scope="col">ingreso</th>
            <th class="header" scope="col">salida</th>
            <th class="header" scope="col">personas</th>
            <th class="header" scope="col">ganancia</th>
            <th class="header" scope="col">caja</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($row as $rows):
            $fecha = strtotime($rows['fecha']); 
        ?>
        <tr style="position: sticky; top: 0; z-index: 10; background-color: #ffffff;">
            <td><?=date('M',$fecha);?></td>
            <td><?=date('Y',$fecha);?></td>
            <td>$ <?=number_format($rows['ingreso'], 2, '.', ',')?></td>
            <td>$ <?=number_format($rows['salida'], 2, '.', ',')?></td>
            <td><?=$rows['personas']?></td>
            <td> $
                <?php
                    $totalGanancia = null;
                    foreach ($row2 as $rows) {
                        $fecha2 = strtotime($rows['fecha']);
                        if (date('m',$fecha2) == date('m',$fecha)) {
                            $gananciaDia = ($rows['ingreso']*30)/100;
                            $totalGanancia +=$gananciaDia;
                        }
                    }
                    echo number_format($totalGanancia, 2, '.', ',');
                ?>
            </td>
            <td> $
                <?php
                    $totalCaja = null;
                    $fecha2 = strtotime($rows['fecha']);
                    foreach ($row2 as $rows) {
                        $fecha2 = strtotime($rows['fecha']);
                        if (date('m',$fecha2) == date('m',$fecha)) {
                            $gananciaDia = $rows['ingreso']-round(($rows['ingreso']*30)/100)-$rows['salida'];
                            $totalCaja +=$gananciaDia;
                        }
                    }
                    echo number_format($totalCaja, 2, '.', ',');
                ?>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>