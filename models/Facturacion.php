<?php
    namespace app\models;

class Facturacion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'facturacion';
    }

    public function rules()
    {
        return[
            [['fecha','año'],'required','message' => 'campo requerido'],
            [['ingreso','salida','personas'],'double','message' => 'Solo permite numeros']
        ];
    }
    public function attributeLabels()
    {
        return[
            'fecha'=>'Fecha:',
            'ingreso'=>'Ingreso:',
            'salida'=>'Salida:',
            'personas'=>'Personas:',
            'año'=>'año:'
        ];
    }
}
    
?>