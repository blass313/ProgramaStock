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
                    'searchModel'=>$searchModel
                ]);
        }
    }

?>