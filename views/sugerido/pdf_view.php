<?php
    use yii\grid\GridView;
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
        <img src="../views/sugerido/img/perro.png" width="80px">
      </div>
      <h1>Forrajeria Lo de Lalo</h1>
      <h4>Pedido para proveedor: <?=$proveedor?></h4>
      <div class="card" style="margin-top: 20px;">
        <div>Calle 11 entre 110 y 112</div>
        <div>(2324)-684826</div>
        <div><a href="mailto:dariomur@hotmail.com">dariomur@hotmail.com</a></div>
      </div>
    </header>
    <main>
        <?=
            GridView::widget([
            'dataProvider' =>$dataProvider,
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
                    'label'=>'Producto',
                ],
                [
                    'attribute'=>'description',
                    'label'=>'Categoria',
                ],
                [
                    'label'=>'Pedido',
                    'value'=>$dif = function($model){
                        $diferencia = $model['sugerido']-$model['stock'];
                        return $diferencia;
                    },
                ],
                ],
            ]);
        ?>
    </main>
    <footer>

    </footer>
  </body>
</html>