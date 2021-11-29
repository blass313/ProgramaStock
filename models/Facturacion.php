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
            [['fecha','tipo','monto'],'required','message' => 'campo requerido'],
            ['monto','integer']
        ];
    }
    public function attributeLabels()
    {
        return[
            'fecha'=>'Fecha:',
            'tipo'=>'Tipo:',
            'monto'=>'Monto:'
        ];
    }
}
    
?>