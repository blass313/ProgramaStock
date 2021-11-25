<?php
    namespace app\models;

    class Distribuidora extends \yii\db\ActiveRecord
    {
        public static function tableName()
        {
            return 'distribuidora';
        }
        public function rules()
        {
            return[
                [['fecha_de_factura','nombre_distribuidora','monto','estado','numero_boleta'],'required','message' => 'Campo requerido']
            ];
        }

        public function attributeLabels()
        {
            return[
                'fecha_de_factura'=> 'fecha de factura:',
                'nombre_distribuidora'=>'nombre distribuidora:',
                'monto'=>'monto:',
                'estado'=>'estado:',
                'numero_boleta'=>'numero boleta:'
            ];
        }
    }
    
?>