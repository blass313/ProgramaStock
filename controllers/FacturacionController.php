<?php
    namespace app\controllers;
    use Yii;
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
            return $this->redirect('facturacion/facturacion');
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

                        if ($dato->update()) {

                                $msg = "El producto ha sido actualizado correctamente";

                            }else{
                                $msg = "El producto no ha podido ser actualizado";
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
    }//class
?>