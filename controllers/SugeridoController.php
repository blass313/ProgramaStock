<?php
    namespace app\controllers;

    use yii\helpers\Html;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use kartik\mpdf\Pdf;
    use Mpdf\Mpdf;
    use app\models\Product;
    use app\models\ProductSearch;


class SugeridoController extends Controller {
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

    public function actionPdf($filtro = null){
            $section = 'sugerido';
            $searchModel = new ProductSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$section);
            $content = $this->renderPartial('pdf_view',['dataProvider'=>$dataProvider]);

            // setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER, 
                'content' => $content,
                'cssInline' => '.kv-heading-1{font-size:18px}', 
                 // set mPDF properties on the fly
                'options' => ['title' => 'Lalo Pedidos'],
                 // call mPDF methods on the fly
                'methods' => [ 
                    'SetHeader'=>['Forrageria lalo'], 
                    'SetFooter'=>['{PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }
        
        public function actionArray(){
            $product = Product::find()
                        ->asArray()
                        ->select('cod,name,description,stock,categoria')
                        //->where('stock < sugerido')
                        //->Where(['categoria'=>'ers'])
                        ->all();
        }
    }
?>