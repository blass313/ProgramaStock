<?php
namespace app\models;

class Product extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function rules(){
        return[
            [['name','description','categoria'],'required','message' => 'campo requerido'],
            [['cod','stock','kg','precio_bolsa','sugerido','porcentajekg','porcentajebolsa'],'double', 'message' => 'permite solo numeros'],
            [['name','description','categoria'],'string', 'message' => 'caracteres no validos']
        ];
    }

    public function attributeLabels()
    {
        return[
            'cod'=> 'Cod:',
            'name'=>'Nombre:',
            'description'=>'Descripcion:',
            'categoria'=>'Proveedor:',
            'stock'=>'Stock:',
            'sugerido'=>'Sugerido:',
            'kg'=>'kg:',
            'precio_bolsa'=>'Precio por bolsa:',
            'porcentajekg'=>'Porcentaje por kg:',
            'porcentajebolsa'=>'porcentaje por bolsa:',
        ];
    }
}
?>