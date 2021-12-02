<?php
    namespace app\controllers;

    use yii\helpers\Html;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use kartik\mpdf\Pdf;
    use app\models\Product;
    use app\models\ProductSearch;


class SugeridoController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','sugerido'],
                'rules' => [
                    [
                        'actions' => ['logout','sugerido'],
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
    public function actionSugerido(){
        $section = 'sugerido';
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$section);
        return $this->render("/sugerido/sugerido", [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionPdf(){
            $section = 'sugerido';
            $query = Product::find()->where('stock < sugerido');
            $content = $this->renderPartial('pdf_view',['dataProvider'=>$query]);
            $pdf = new Pdf();
    }
}
?>