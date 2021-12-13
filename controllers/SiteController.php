<?php

namespace app\controllers;

use Yii;

use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use app\models\ProductSearch;
use app\models\LoginForm;
use app\models\Product;

class SiteController extends Controller{
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout','update','index'],
                'rules' => [
                    [
                        'actions' => ['logout','update','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        $model = new Product();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $datos = new Product();

                $datos->cod = $model->cod;
                $datos->name = strtoupper($model->name);
                $datos->description = strtoupper($model->description);
                $datos->categoria = strtoupper($model->categoria);
                $datos->stock = $model->stock;
                $datos->sugerido = $model->sugerido;
                $datos->kg = $model->kg;
                $datos->precio_bolsa = $model->precio_bolsa;
                $datos->porcentajekg = $model->porcentajekg;
                $datos->porcentajebolsa = $model->porcentajebolsa;
                
                $model = new Product();
            }else {
                $model->getErrors();
            }
        }
        $searchModel = new ProductSearch();

        if (Yii::$app->request->post('hasEditable')) {
            $this->actionUpdateStock();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }//index

    public function actionDelete($id = null){
        $model = Product::findOne($id);

		$model->delete();
        return $this->redirect('index');
    }//delete

    public function actionUpdate(){
        $model = new Product;
        $msg = null;

        if($model->load(Yii::$app->request->post())){

            if($model->validate()){

                $datos = product::findOne($_GET["id"]);

                if($datos){
                    $datos->cod = $model->cod;
                    $datos->name = strtoupper($model->name); 
                    $datos->description = strtoupper($model->description);
                    $datos->categoria = strtoupper($model->categoria);
                    $datos->stock = $model->stock;
                    $datos->sugerido = $model->sugerido;
                    $datos->kg = $model->kg;
                    $datos->precio_bolsa = $model->precio_bolsa;
                    $datos->porcentajekg = $model->porcentajekg;
                    $datos->porcentajebolsa = $model->porcentajebolsa;
    
                    if ($datos->update())
                    {
                        $msg = "El producto ha sido actualizado correctamente";
                    }
                    else
                    {
                        $msg = "El producto no ha podido ser actualizado";
                    }
                }
                else
                {
                    $msg = "El producto seleccionado no ha sido encontrado";
                }
            }
            else{
                $model->getErrors();
            }
        }

        if (Yii::$app->request->get("id")){
            $id = Html::encode($_GET["id"]);
            if ((int) $id){
                $datos = product::findOne($id);
                if($datos)
                {
                    $model->cod = $datos->cod;
                    $model->name = $datos->name;
                    $model->description = $datos->description;
                    $model->categoria = $datos->categoria;
                    $model->stock = $datos->stock;
                    $model->sugerido = $datos->sugerido;
                    $model->kg = $datos->kg;
                    $model->precio_bolsa = $datos->precio_bolsa;
                    $model->porcentajekg = $datos->porcentajekg;
                    $model->porcentajebolsa = $datos->porcentajebolsa;
                }
                else{
                    return $this->redirect(["index"]);
                }
            }
            else{
                return $this->redirect(["index"]);
            }
        }
        else{
            return $this->redirect(["index"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }//update
    
    public function actionLogin(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUpdateStock() {
        $model = new Product();

        if (isset($_POST['hasEditable'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($model->load($_POST)) {
                $value = $model->stock;
                $model->save();
                
                return ['output'=>$value, 'message'=>''];

            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output'=>'', 'message'=>''];
            }
        }
        
        // Else return to rendering a normal view
        //return $this->render('view', ['model'=>$model]);
    }
}
