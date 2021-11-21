<?php
    namespace app\controllers;

    use yii\helpers\Html;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;

    use app\models\SugeridoSearch;
    use app\models\Product;
    use app\models\ProductForm;

class SugeridoController extends Controller{
    public function behaviors()
    {
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
        
        $searchModel = new SugeridoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render("/sugerido/sugerido", [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
?>