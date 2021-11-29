<?php
    namespace app\controllers;
    use Yii;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;

    use app\models\FacturacionSearch;
    use app\models\Facturacion;

    class FacturacionController extends Controller{
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

        function actionFacturacion(){
            $model = new facturacion();
            $monto = $this->actionconversorMonto();
            $fecha = $this->actionConversorFecha();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $datos = new facturacion();

                    $datos->fecha = $model->fecha;
                    $datos->tipo = $model->tipo;
                    $datos->monto = $model->monto;
                }
            }
            $searchModel = new FacturacionSearch();
        
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('/facturacion/facturacion',[
                    'model'=>$model,
                    'dataProvider'=>$dataProvider,
                    'searchModel'=>$searchModel,
                    'montos'=>$monto,
                    'fecha'=>$fecha
                ]);
        }

        public function actionconversorMonto(){
            $montos = facturacion::find()
                                ->select('monto')
                                //->where(['tipo'=>'ingreso'])
                                ->asArray()
                                ->all();
            $montoConv = [];
            $i = 0;
            foreach ($montos as $monto) {
                foreach ($monto as $m) {
                    $montoConv[$i] = (int)$m;
                    $i++;
                }
            }
            return $montoConv;
        }
    
        function actionConversorFecha(){
            $Fechas = facturacion::find()
                                ->select('fecha')
                                ->asArray()
                                ->orderBy(['fecha' =>'asc'])
                                ->all();
            $ArrayFecha = [];
            $i = 0;
            foreach ($Fechas as $Fecha) {
                foreach ($Fecha as $f) {
                    $ArrayFecha[$i]= $f;
                    $i++;
                }
            }
            return $ArrayFecha;
        }

        public function actionDelete($id = null){
            $model = facturacion::findOne($id);
            $model->delete();
            return $this->redirect('facturacion');
        }//delete
    }//class
?>