<?php

namespace app\controllers;

use Yii;

use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use kartik\mpdf\Pdf;

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
        $modelProduct = new Product();

        if (Yii::$app->request->post('hasEditable')) {
            $this->actionStock(Yii::$app->request->post('editableAttribute'));
        }

        $searchGeneralModel = new ProductSearch();
        $dataGeneral = $searchGeneralModel->searchGeneral(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchGeneralModel' => $searchGeneralModel,
            'dataGeneral' => $dataGeneral,
            'modelProduct' => $modelProduct,
        ]);
    }

    public function actionCreate(){
        $productCreate = new Product();
		
        if ($productCreate->load(Yii::$app->request->post()) && $productCreate->save()){
            $model = new Product();
            }else {
                $productCreate->getErrors();
            }
            return $this->redirect('index');
    }

    public function actionDelete($id = null){
        $model = Product::findOne($id);

		$model->delete();
        return $this->redirect(['index']);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect("index");
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id){
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
    }

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

    public function actionGeneralpdf(){
        $searchPdf = new ProductSearch();
        $dataPdf = $searchPdf->searchGeneral(Yii::$app->request->queryParams);
        $content = $this->renderPartial('pdf_StockGeneral',['dataPdf'=>$dataPdf]);
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

    public function actionStock($row) {
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
