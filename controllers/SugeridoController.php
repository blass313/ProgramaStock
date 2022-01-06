<?php
    namespace app\controllers;

    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use kartik\mpdf\Pdf;
    use app\models\SugeridoSearch;


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
        $searchSugeridoModel = new SugeridoSearch();
        $dataSugerido = $searchSugeridoModel->searchSugerido(Yii::$app->request->queryParams);

        return $this->render("/sugerido/sugerido", [
            'searchSugeridoModel' => $searchSugeridoModel,
            'dataSugerido' => $dataSugerido,
        ]);
    }

    public function actionSugeridopdf($filtro = null){
                $filtro = Yii::$app->request->get('proveedor');
                //$section = 'pdf';
                $searchSugeridopdf = new SugeridoSearch();
                $dataPdf = $searchSugeridopdf->searchSugeridopdf(Yii::$app->request->queryParams,$filtro);
                $content = $this->renderPartial('pdf_view',['dataPdf'=>$dataPdf,'proveedor'=>$filtro]);
                $nombre = 'Pedido lo de lalo para '.$filtro.'.pdf';

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
                ],
                'filename' => $nombre
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
    }
}
?>