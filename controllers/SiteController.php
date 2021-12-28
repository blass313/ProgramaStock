<?php

namespace app\controllers;

use Yii;

use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use kartik\mpdf\Pdf;
use kartik\widgets\Alert;

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

        if (Yii::$app->request->post('hasEditable')) {
            $this->stock(Yii::$app->request->post('editableAttribute'));
        }

        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }//index

    public function actionCreate(){
        $model = new Product();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $model = new Product();
            }else {
                $model->getErrors();
            }
            return $this->redirect('index');
    }

    public function actionDelete($id = null){
        $model = Product::findOne($id);

		$model->delete();
        return $this->redirect(['index']);
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
                else
                {
                    $msg = Alert::widget([
                        'type' => Alert::TYPE_WARNING,
                        'title' => 'Cuidado!',
                        'icon' => 'fas fa-exclamation-circle',
                        'body' => 'El producto no se encontro',
                        'showSeparator' => true,
                        'delay' => 2000
                    ]);
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

    public function actionPdf($filtro = null, $sector = null){
        $section = 'general';
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$section,$filtro);
        $content = $this->renderPartial('pdf_StockGeneral',['dataProvider'=>$dataProvider]);
        $nombre = 'Stock General.pdf';

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_DOWNLOAD, 
            'content' => $content,
            'options' => ['title' => 'Stock general'],
            'methods' => [ 
                'SetFooter'=>['{PAGENO}'],
            ],
            'filename' => $nombre
        ]);
        return $pdf->render();
    }

    public function stock($row) {
        $datos = product::findOne(Yii::$app->request->post('editableKey'));
        if (isset($_POST['hasEditable'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($datos->load($_POST)) {
                $datos->$row = $_POST['Product'][Yii::$app->request->post('editableIndex')][$row];
                $datos->save();
                $salida = ['output'=>'','message'=>''];
                $out = Json::encode($salida);
                return ['output'=>$out, 'message'=>''];
            }
            else {
                return ['output'=>'', 'message'=>''];
            }
        }
    }
}
