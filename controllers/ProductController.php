<?

namespace app\controllers;

use yii\base\Controller;
use app\models\ProductSearch;
use app\models\Product;

class ProductController extends Controller
{
    public function actionIndex()
    {
        $model = new ProductSearch();
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
}