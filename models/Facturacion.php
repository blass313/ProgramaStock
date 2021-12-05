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
            [['fecha','ingreso','salida','personas'],'required','message' => 'campo requerido'],
        ];
    }
    public function attributeLabels()
    {
        return[
            'fecha'=>'Fecha:',
            'ingreso'=>'Ingreso:',
            'salida'=>'Salida:',
            'personas'=>'Personas:'
        ];
    }
}
    
?>