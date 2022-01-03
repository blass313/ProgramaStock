<?php
    namespace app\controllers;
    use Yii;

    use kartik\widgets\Alert;

    use yii\web\Controller;
    use yii\helpers\Html;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;
    use yii\helpers\Url;

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
            $model = new facturacion;

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $model = new facturacion();
                }
            }
            $searchModel = new FacturacionSearch();
        
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('/facturacion/facturacion',[
                    'model'=>$model,
                    'dataProvider'=>$dataProvider,
                    'searchModel'=>$searchModel,
                ]);
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
            $model = new facturacion;
            $model2 = new FacturacionSearch();
            if(!empty($model2->load(Yii::$app->request->get()))){
                $año = Html::encode($model2->año);

                $query = "SELECT MONTH(Fecha) AS Mes, YEAR(Fecha) AS Ano, fecha, SUM(ingreso) AS ingreso, SUM(salida) AS salida,SUM(personas) AS personas FROM facturacion WHERE YEAR(Fecha) = '$año' GROUP BY Mes, Ano ORDER BY fecha";
                $row = $model->findBySql($query)->asArray()->all();
    
                $query2 = "SELECT * FROM facturacion";
                $row2 = $model->findBySql($query2)->asArray()->all();

                return $this->render('/facturacion/resumenmes',['row'=>$row, 'row2'=>$row2,'model'=>$model,'model2'=>$model2]);                
            }else {
                $query = "SELECT MONTH(Fecha) AS Mes, YEAR(Fecha) AS Ano, fecha, SUM(ingreso) AS ingreso, SUM(salida) AS salida,SUM(personas) AS personas FROM facturacion GROUP BY Mes, Ano ORDER BY fecha";
                $row = $model->findBySql($query)->asArray()->all();
    
                $query2 = "SELECT * FROM facturacion";
                $row2 = $model->findBySql($query2)->asArray()->all();
                return $this->render('/facturacion/resumenmes',['row'=>$row, 'row2'=>$row2,'model'=>$model,'model2'=>$model2]);
            }
        }

        public function actionDelete($id = null){
            $model = facturacion::findOne($id);
            $model->delete();
            return $this->redirect(['facturacion']);
        }//delete

        public function actionUpdate(){
            $model = new Facturacion;
            $msg = null;

            if ($model->load(Yii::$app->request->post())){

                if ($model->validate()){

                    $dato = Facturacion::findOne($_GET['id']);
                    if ($dato) {

                        $dato->fecha = $model->fecha;
                        $dato->ingreso = $model->ingreso;
                        $dato->salida = $model->salida;
                        $dato->personas = $model->personas;

                        if ($dato->update())
                        {
                        $msg =  Alert::widget([
                                    'type' => Alert::TYPE_SUCCESS,
                                    'title' => 'Carga Exitosa',
                                    'icon' => 'fas fa-check-circle',
                                    'body' => 'El items a sido modificado con exito',
                                    'showSeparator' => true,
                                    'delay' => 2000,
                                ]);
                        }
                        else
                        {
                            $msg =  Alert::widget([
                                        'type' => Alert::TYPE_DANGER,
                                        'title' => 'Fallo al cargar los datos',
                                        'icon' => 'fas fa-times-circle',
                                        'body' => 'Algo salio mal y no se pudo cargar el producto',
                                        'showSeparator' => true,
                                        'delay' => 2000
                                    ]);
                        }
                    }
                }
            }

                if (Yii::$app->request->get('id')){
                    $id = Html::encode($_GET['id']);
                    if ((int)$id){
                        $dato = Facturacion::findOne($id);
                        if ($dato) {
                            $model->fecha = $dato->fecha;
                            $model->ingreso = $dato->ingreso;
                            $model->salida = $dato->salida;
                            $model->personas = $dato->personas;
                            }else{
                                return $this->redirect(["facturacion"]);
                            }
                        }else{
                            return $this->redirect(["facturacion"]);
                        }
                    }else{
                        return $this->redirect(["facturacion"]);
                    }
            return $this->render('update',['model'=>$model,'msg'=>$msg]);
        }//update

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