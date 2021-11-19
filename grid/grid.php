<?php
    namespace app\grid;
    use app\models\Product;
    use app\models\ProductForm;
    
    class grid
    {
        public static function color($stock,$sugerido){

            $diferencia = $stock-$sugerido;
            if ($diferencia<0) {
                return 'red';
            }elseif($diferencia == 0){
                return 'yellow';                                   
            }else {
                return 'green';
            }
        }
    }
    
?>