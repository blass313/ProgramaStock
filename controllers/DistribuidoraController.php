<?php
    namespace app\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;

    use app\models\Distribuidora;
    use app\models\DistribuidoraSearch;

class DistribuidoraController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','update'],
                'rules' => [
                    [
                        'actions' => ['logout','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionDistribuidora(){

        $model = new distribuidora();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $datos = new distribuidora();

                $datos->fecha_de_factura = $model->fecha_de_factura;
                $datos->nombre_distribuidora = $model->nombre_distribuidora;
                $datos->monto = $model->monto;
                $datos->estado = $model->estado;
                $datos->numero_boleta = $model->numero_boleta;
    
                $model = new distribuidora();    
            }else {
                $model->getErrors();
            }
        }//load

        $searchModel = new DistribuidoraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render("/distribuidora/distribuidora",[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
}//class
?>