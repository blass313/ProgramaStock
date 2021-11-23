<?php
    namespace app\models;

    use Yii;
    use yii\base\Model;

    class FormDistribuidora extends Model{
        public $fecha_de_factura;
        public $nombre_distribuidora;
        public $monto;
        public $estado;
        public $numero_boleta;

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