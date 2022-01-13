<?php
    namespace app\controllers;

    use app\models\Product;
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

    public function actionSugerido($check = null){
        $searchSugeridoModel = new SugeridoSearch();
        $dataSugerido = $searchSugeridoModel->searchSugerido(Yii::$app->request->queryParams);

        return $this->render("/sugerido/sugerido", [
            'searchSugeridoModel' => $searchSugeridoModel,
            'dataSugerido' => $dataSugerido,
            'check'=>$check
        ]);
    }

    public function actionSugeridopdf($filtro = null){
                $filtro = Yii::$app->request->get('proveedor');
                $dataPdf = Product::find()
                                ->where(['categoria' => $filtro])
                                ->andWhere('stock < sugerido')
                                ->all();

                $montoTotal = $this->actionMontototal($dataPdf);
                $content = $this->renderPartial('pdf_view',['dataPdf'=>$dataPdf,'proveedor'=>$filtro,'montoTotal'=>$montoTotal]);
                $nombre = 'Pedido lo de lalo para '.$filtro.' '.date("d.m.y").'.pdf';

            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER, 
                'content' => $content,
                'cssInline' => '.kv-heading-1{font-size:18px}',
                'options' => ['title' => 'Lalo Pedidos'],
                'methods' => [ 
                    'SetHeader'=>['Forrageria lalo'], 
                    'SetFooter'=>['{PAGENO}'],
                ],
                'filename' => $nombre
            ]);
            return $pdf->render();
    }

    public function actionCheckbox(){
        $ids = Yii::$app->request->post('selection');
        $dataPdf = Product::find()
                            ->where(['id' => $ids])
                            ->all();
        $montoTotal = $this->actionMontototal($dataPdf);
                            
        $content = $this->renderPartial('pdf_filtrado',['dataPdf'=>$dataPdf, 'montoTotal'=>$montoTotal]);
        $nombre = 'Pedido lo de lalo'.date("d.m.y").'.pdf';

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'content' => $content,
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            'options' => ['title' => 'Lalo Pedidos'],
            'methods' => [ 
                'SetHeader'=>['Forrageria lalo'], 
                'SetFooter'=>['{PAGENO}'],
            ],
            'filename' => $nombre
        ]);
        return $pdf->render();
    }

    private function actionMontototal($consultaMysql){
        $montoTotal = null;
        foreach ($consultaMysql as $producto) {
          $montoTotal += $producto['precio_bolsa'] *($producto['sugerido']-$producto['stock']);
        }
        return number_format($montoTotal,2,'.',',');
    }
}
?>