<?php
    use kartik\grid\GridView;
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body class="card">
    <header style="margin-bottom: 50px; margin-top: 50px;">
      <div id="logo">
        <img src="../views/site/img/en-stock.png" width="50px">
      </div>
    </header>
    <main>
        <?=
            GridView::widget([
            'dataProvider' =>$dataProvider,
            'columns'=>[
                [
                    'attribute'=>'name',
                    'label'=>'Producto',
                    'headerOptions' => ['style' => 'font-weight: bold'],
                ],
                [
                    'attribute'=>'description',
                    'label'=>'Categoria',
                ],
                [
                  'attribute'=>'kg',
                  'hAlign'=>'center',
                  'vAlign' => 'center',
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
                  'hAlign' => 'right',
                  'format' => ['decimal', 2],
              ],
                ],
            ]);
        ?>
    </main>
    <footer>

    </footer>
  </body>
</html>