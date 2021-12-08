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

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $datos = new facturacion();

                    $datos->fecha = $model->fecha;
                    $datos->ingreso = $model->ingreso;
                    $datos->salida = $model->salida;
                    $datos->personas = $model->personas;

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

        public function actionDelete($id = null){
            $model = facturacion::findOne($id);
            $model->delete();
            return $this->redirect('/facturacion/facturacion');
        }//delete
    }//class
?>