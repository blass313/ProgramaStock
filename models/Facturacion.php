<?php
    namespace app\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;

class Facturacion extends \yii\db\ActiveRecord{
    public $fechaDesde;
    public $fechaHasta;
    public $año;

    public static function tableName()
    {
        return 'facturacion';
    }

    public function rules(){
        return [
            ['id', 'integer'],
            [['ingreso','salida','personas'],'double','message' => 'Solo permite numeros'],
            ['año', 'safe'],
            [['fechaDesde','fechaHasta'],'validateDates'],
            [['fecha'],'required','message' => 'campo requerido'],
        ];
    }

    public function validateDates($attribute){
        if(!$this->hasErrors() && strtotime($this->fechaDesde) > strtotime($this->fechaHasta)){
            $this->addError('fechaDesde','escriba de forma correcta el rango');
        }
    }

    public function attributeLabels(){
        return[
            'fecha'=>'Fecha:',
            'ingreso'=>'Ingreso:',
            'salida'=>'Salida:',
            'personas'=>'Personas:',
        ];
    }
}
    
?>