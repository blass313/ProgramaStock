<?php
    namespace app\controllers;

use app\models\FormDistribuidora;
use yii\web\Controller;

class DistribuidoraController extends Controller{
    public function actionDistribuidora(){
        $model = new FormDistribuidora();
        return $this->render("/distribuidora/distribuidora",["model"=>$model]);
    }
    
}//class
?>