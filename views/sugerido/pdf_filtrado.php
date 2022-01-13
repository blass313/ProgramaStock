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
      <h4>Pedido de productos seleccionados</h4>
      <h4>Fecha de pedido: <?=date("d.m.y")?></h4>
      <div class="card" style="margin-top: 20px;">
        <div>Calle 11 entre 112 y 114</div>
        <div>(2324)-684826</div>
        <div><a href="mailto:dariomur@hotmail.com">dariomur@hotmail.com</a></div>
      </div>
    </header>
    <main>
        <table class="table table-sm table-dark">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripcion</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($dataPdf as $producto) {
                ?>
                    <tr>
                        <td><?=$producto['name']?></td>
                        <td><?=$producto['description']?></td>
                        <td><?=$producto['categoria']?></td>
                        <td><?=$diferencia = $producto['sugerido']-$producto['stock'];?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
            <tfoot>
              <tr class="table-info">
              <th style="background-color: lightblue;" colspan="3">Monto aproximado:</th>
                <td style="background-color: lightblue;">$ <?=$montoTotal?></td>
              </tr>
            </tfoot>
        </table>
    </main>
    <footer>
    </footer>
  </body>
</html>