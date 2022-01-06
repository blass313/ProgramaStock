<?php
    namespace app\controllers;
    use Yii;

    use kartik\widgets\Alert;

    use yii\web\Controller;
    use yii\helpers\Html;
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
            $modelFacturacion = new facturacion;
            $searchFacturacionModel = new FacturacionSearch;
        
            $dataFacturacion = $searchFacturacionModel->searchFacturacion(Yii::$app->request->queryParams);
            return $this->render('/facturacion/facturacion',[
                    'modelFacturacion'=>$modelFacturacion,
                    'dataFacturacion'=>$dataFacturacion,
                    'searchFacturacionModel'=>$searchFacturacionModel,
                ]);
        }

        public function actionCreate(){
            $createFacturacion = new facturacion;
            if ($createFacturacion->load(Yii::$app->request->post())) {
                if ($createFacturacion->save()) {
                    $createFacturacion = new facturacion();
                }else {
                    $createFacturacion->getErrors();
                }
                return $this->redirect(['facturacion']);
            }
        }
        
        public function actionDelete($id = null){
            $model = facturacion::findOne($id);
            $model->delete();
            return $this->redirect(['facturacion']);
        }

        public function actionUpdate($id){
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['facturacion']);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        protected function findModel($id){
            if (($model = Facturacion::findOne($id)) !== null) {
                return $model;
            }
        }

        public function actionRangofacturacion($rows = null, $formFecha = null){
            $model = new facturacion;
            $formFecha = new FacturacionSearch;

            if(!empty($formFecha->load(Yii::$app->request->get()))){
                $rows = $this->actionSearchMes($model,$formFecha);
            }else {
                $rows = $this->actionFacturacionMes();
            }
            return $this->render(
                '/facturacion/Rangofacturacion',
                [    
                    "rows" => $rows,
                    "formFecha" => $formFecha
                ]);
        }

        public function actionResumenmes(){
            $modelAño = new Facturacion;

            if(!empty($modelAño->load(Yii::$app->request->get()))){
                $año = Html::encode($modelAño->año);

                $query = "SELECT MONTH(Fecha) AS Mes, YEAR(Fecha) AS Ano, fecha, SUM(ingreso) AS ingreso, SUM(salida) AS salida,SUM(personas) AS personas FROM facturacion WHERE YEAR(Fecha) = '$año' GROUP BY Mes, Ano ORDER BY fecha";
                $row = $modelAño->findBySql($query)->asArray()->all();
    
                $queryFilter = "SELECT * FROM facturacion";
                $rowFilters = $modelAño->findBySql($queryFilter)->asArray()->all();

                return $this->render('/facturacion/resumenmes',['row'=>$row, 'rowFilters'=>$rowFilters,'modelAño'=>$modelAño]);                
            }else {
                $query = "SELECT MONTH(Fecha) AS Mes, YEAR(Fecha) AS Ano, fecha, SUM(ingreso) AS ingreso, SUM(salida) AS salida,SUM(personas) AS personas FROM facturacion GROUP BY Mes, Ano ORDER BY fecha";
                $row = $modelAño->findBySql($query)->asArray()->all();
    
                $queryFilter = "SELECT * FROM facturacion";
                $rowFilters = $modelAño->findBySql($queryFilter)->asArray()->all();
                return $this->render('/facturacion/resumenmes',['row'=>$row, 'rowFilters'=>$rowFilters,'modelAño'=>$modelAño]);
            }
        }

        public function actionFacturacionMes(){
            $table = new Facturacion();
            return $table->find()->all();
        }

        public function actionSearchMes($model,$formFecha){
        
            if ($formFecha->validate()){
                $desde = Html::encode($formFecha->fechaDesde);
                $hasta = Html::encode($formFecha->fechaHasta);
                if (!empty($desde) && !empty($hasta)) {
                    $query = "SELECT * FROM facturacion WHERE fecha BETWEEN '$desde' AND '$hasta'";
                    return $model->findBySql($query)->all();
                }else {
                    $query = "SELECT * FROM facturacion";
                    return $model->findBySql($query)->asArray()->all();
                }
                
            }else{
                $formFecha->getErrors();
            }
        }
    }//class
?>