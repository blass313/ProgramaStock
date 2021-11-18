<?php

namespace app\controllers;

use Yii;

use yii\helpers\Html;
use app\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
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

    /**
     * {@inheritdoc}
     */
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


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
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
                $datos->status = $model->status;
                $datos->precio_unidad = $model->precio_unidad;
                $datos->precio_bulto = $model->precio_bulto;

                if ($datos->insert()) {
                    $model->cod=null;
                    $model->name=null;
                    $model->description=null;
                    $model->categoria=null;
                    $model->status=null;
                    $model->precio_unidad=null;
                    $model->precio_bulto=null;
                    
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
            'model' => $model
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
                    $datos->status = $model->status;
                    $datos->precio_unidad = $model->precio_unidad;
                    $datos->precio_bulto = $model->precio_bulto;
    
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
                    $model->status = $datos->status;
                    $model->precio_unidad = $datos->precio_unidad;
                    $model->precio_bulto = $datos->precio_bulto;
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

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    public function actionRegistro(){
        return $this->render('registro/registro');
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
