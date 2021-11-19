<?php
    namespace app\models;

    use Yii;
    use yii\base\Model;

    class ProductForm extends Model{
        public $cod;
        public $name;
        public $description;
        public $categoria;
        public $stock;
        public $sugerido;
        public $precio_por_kg;
        public $precio_bolsa;
        public $porcentajekg;
        public $porcentajebolsa;

        public function rules()
        {
            return[
                [['cod','name','description','categoria','stock','precio_por_kg','precio_bolsa','sugerido','porcentajekg','porcentajebolsa'],'required','message' => 'campo requerido'],
                [['cod','stock'],'integer', 'message' => 'permite solo numeros'],
                [['name','description','categoria'],'string', 'message' => 'caracteres no validos']
            ];
        }

        public function attributeLabels()
        {
            return[
                'cod'=> 'Cod:',
                'name'=>'Nombre:',
                'description'=>'Descripcion:',
                'categoria'=>'Categoria:',
                'stock'=>'Stock:',
                'sugerido'=>'Sugerido:',
                'precio_por_kg'=>'Precio por kg:',
                'precio_bolsa'=>'Precio por bolsa:',
                'porcentajekg'=>'Porcentaje por kg:',
                'porcentajebolsa'=>'porcentaje por bolsa:',
            ];
        }
    }
?>