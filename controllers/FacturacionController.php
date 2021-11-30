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
                    'only' => ['logout','facturacion'],
                    'rules' => [
                        [
                            'actions' => ['logout','facturacion'],
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
            $fechaIngreso = $this->actionFechaIngreso();
            $fechaSalida = $this->actionFechaSalida();
            $salida = $this->actionMontoSalida();

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
                    'montosIngreso'=>$monto,
                    'fechaIngreso'=>$fechaIngreso,
                    'fechaSalida'=>$fechaSalida,
                    'montoSalida'=>$salida
                ]);
        }

        public function actionconversorMonto(){
            $montos = facturacion::find()
                                ->select('monto')
                                ->where(['tipo'=>'ingreso'])
                                ->asArray()
                                ->all();
            $montoConv = [];
            $i = 0;
            foreach ($montos as $monto) {
                foreach ($monto as $m) {
                    $montoConv[$i] = ((int)$m*30)/100;
                    $i++;
                }
            }
            return $montoConv;
        }

        public function actionMontoSalida(){
            $montosSalida = facturacion::find()
                                ->select('monto')
                                ->where(['tipo'=>'salida'])
                                ->asArray()
                                ->all();
            $montosSalidaTotal = [];
            $i = 0;
            foreach ($montosSalida as $salida) {
                foreach ($salida as $S) {
                    $montosSalidaTotal[$i] = (int)$S;
                    $i++;
                }
            }
            return $montosSalidaTotal;
        }
    
        function actionFechaIngreso(){
            $Fechas = facturacion::find()
                                ->select('fecha')
                                ->where(['tipo'=>'ingreso'])
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

        function actionFechaSalida(){
            $Fechas = facturacion::find()
                                ->select('fecha')
                                ->where(['tipo'=>'salida'])
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