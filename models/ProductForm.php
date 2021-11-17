<?php
    namespace app\models;

    use Yii;
    use yii\base\Model;

    class ProductForm extends Model{
        public $cod;
        public $name;
        public $description;
        public $categoria;
        public $status;
        public $precio_unidad;
        public $precio_bulto;

        public function rules()
        {
            return[
                [['cod','name','description','categoria','status','precio_unidad','precio_bulto'],'required','message' => 'campo requerido'],
                [['cod','status'],'integer', 'message' => 'permite solo numeros'],
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
                'status'=>'Stock:',
                'precio_unidad'=>'Precio unitario',
                'precio_bulto'=>'Precio por bulto:',
            ];
        }
    }
?>