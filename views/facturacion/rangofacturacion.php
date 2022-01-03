<?php
    namespace app\models;

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;

    $this->title = 'facturacion por rango';
?>
 <h1>Facturacion por rango</h1>
    <?php 
        $fechas = ActiveForm::begin([
            "method" => "get",
            'id' => 'busquedaFecha',
            "enableClientValidation" => true,
        ]);
    ?>
        <div class="form-row">
            <div class="col-4">
                    <?= 
                        $fechas->field($formFecha, 'fechaDesde')->widget(DatePicker::class, [
                            'options' => [
                                'placeholder' => 'Fecha desde', 
                                'autocomplete' => "off",
                                'id'=>'desde'
                            ],
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                            'autoclose' => true,
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy/mm/dd'
                            ]
                        ]);
                    ?>
            </div>
            <div class="col-4">
                <?= 
                    $fechas->field($formFecha, 'fechaHasta')->widget(DatePicker::class, [
                        'options' => [
                            'placeholder' => 'Fecha hasta', 
                            'autocomplete' => "off",
                            'id'=>'hasta'
                        ],
                        'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'autoclose' => true,
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy/mm/dd'
                        ]
                    ]);
                ?>
            </div>
            </div><!--form row-->  
            <div class="form-row" style="padding-bottom: 10px;">
            <div class="col-4">
                <?= Html::submitButton("Buscar", ["class" => "btn btn-primary", "id"=>"buscar"]);?>
            </div>
        </div>          
            <?php 
                ActiveForm::end();
            ?>
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>Total de personas </th>
                <th>Total de ganancia</th>
                <th>Total de caja</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php   
                        $totalPersonas = null; 
                        foreach ($rows as $row) {
                            $totalPersonas +=$row['personas'];
                        }
                        echo $totalPersonas;
                    ?>
                </td>
                <td> $
                    <?php
                            $totalGanancia = null;
                            foreach ($rows as $row) {
                                $gananciaDia = ($row['ingreso']*30)/100;
                                $totalGanancia +=$gananciaDia;
                            }
                            echo number_format($totalGanancia, 2, '.', ',');
                    ?>
                </td>
                <td> $
                    <?php
                        $totalCaja = null;
                        foreach ($rows as $row) {
                            $gananciaDia = $row['ingreso']-round(($row['ingreso']*30)/100)-$row['salida'];
                            $totalCaja +=$gananciaDia;
                        }
                        echo number_format($totalCaja, 2, '.', ',');
                    ?>
                </td>
            </tr>
        </tbody>
</table>
    <table class="table" id="tabla" style="height:200px;
            overflow:scroll;">
            <thead class="thead-dark">
                <tr style="position: sticky; top: 0; z-index: 10; background-color: #ffffff;">
                    <th class="header" scope="col">Fecha</th>
                    <th class="header" scope="col">Ingreso</th>
                    <th class="header" scope="col">Salida</th>
                    <th class="header" scope="col">Personas</th>
                    <th class="header" scope="col">ganancia</th>
                    <th class="header" scope="col">caja</th>
                </tr>
            </thead>
            <?php
                foreach($rows as $row):
            ?>
                <tbody>
                    <tr style="position: sticky; top: 0; z-index: 10; background-color: #ffffff;">
                        <td><?=$row['fecha'];?></td>
                        <td>$ <?=number_format($row['ingreso'], 2, '.', ',')?></td>
                        <td>$ <?=number_format($row['salida'], 2, '.', ',')?></td>
                        <td><?=$row['personas']?></td>
                        <td>$ <?=number_format(round(($row['ingreso']*30)/100), 2, '.', ','); ?></td>
                        <td>$ <?=number_format($row['ingreso']-round(($row['ingreso']*30)/100)-$row['salida'], 2, '.', ',');?></td>
                    </tr>
                </tbody>
            <?php
                endforeach;
            ?>
    </table>