<?php

namespace app\controllers;

use Yii;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\ProductSearch;
use app\models\LoginForm;
use app\models\Product;
use app\models\ProductForm;

class SiteController extends Controller
{
    public function behaviors()
    {
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
    public function actions()
    {
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
    
    public function actionIndex($mensaje = null)
    {
        $model = new ProductForm;
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $datos = new Product();

                $datos->cod = $model->cod;
                $datos->name = $model->name;
                $datos->description = $model->description;
                $datos->categoria = $model->categoria;
                $datos->stock = $model->stock;
                $datos->sugerido = $model->sugerido;
                $datos->precio_por_kg = $model->precio_por_kg;
                $datos->precio_bolsa = $model->precio_bolsa;
                $datos->porcentajekg = $model->porcentajekg;
                $datos->porcentajebolsa = $model->porcentajebolsa;

                if ($datos->insert()) {
                    $model->cod=null;
                    $model->name=null;
                    $model->description=null;
                    $model->categoria=null;
                    $model->stock=null;
                    $model->sugerido=null;
                    $model->precio_por_kg=null;
                    $model->precio_bolsa=null;
                    $model->porcentajebolsa=null;
                    $model->porcentajekg=null;
                    
                }
            }else {
                $model->getErrors();
            }
        }

        $searchModel = new ProductSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'mensaje'=>$mensaje
        ]);
    }

    public function actionDelete($id = null){
        $model = Product::findOne($id);

		$model->delete();
        return $this->redirect('index');
    }
    
    public function actionUpdate(){
        $model = new ProductForm;
        $msg = null;
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $datos = product::findOne($_GET["id"]);
                if($datos)
                {
                    $datos->cod = $model->cod;
                    $datos->name = $model->name;
                    $datos->description = $model->description;
                    $datos->categoria = $model->categoria;
                    $datos->stock = $model->stock;
                    $datos->sugerido = $model->sugerido;
                    $datos->precio_por_kg = $model->precio_por_kg;
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
            else
            {
                $model->getErrors();
            }
        }

        if (Yii::$app->request->get("id"))
        {
            $id = Html::encode($_GET["id"]);
            if ((int) $id)
            {
                $datos = product::findOne($id);
                if($datos)
                {
                    $model->cod = $datos->cod;
                    $model->name = $datos->name;
                    $model->description = $datos->description;
                    $model->categoria = $datos->categoria;
                    $model->stock = $datos->stock;
                    $model->sugerido = $datos->sugerido;
                    $model->precio_por_kg = $datos->precio_por_kg;
                    $model->precio_bolsa = $datos->precio_bolsa;
                    $model->porcentajekg = $datos->porcentajekg;
                    $model->porcentajebolsa = $datos->porcentajebolsa;
                }
                else
                {
                    return $this->redirect(["index"]);
                }
            }
            else
            {
                return $this->redirect(["index"]);
            }
        }
        else
        {
            return $this->redirect(["index"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }
    public function actionMercaderia(){
        $msj = null;
        
        if (Yii::$app->request->get("cod"))
        {
            $cod = Html::encode($_GET["cod"]);
            $datos = product::find()
                     ->where(['cod'=>$cod]);
            $agregarMercaderia = $_REQUEST['stock'];
            if($datos)
            {
                $total = $datos->stock + $agregarMercaderia;
                $datos->stock = $total;
                if ($datos->update()) {
                    $msj = "datos cargados";
                }else{
                    $msj = "no se pudieron cargar";
                }
            }
        }
        return $this->redirect(['index',"mensaje"=>$msj]);
    }

    public function actionLogin()
    {
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
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
