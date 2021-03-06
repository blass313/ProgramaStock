<?php
    namespace app\controllers;

    use Yii;
    use yii\web\Controller;

    use yii\widgets\ActiveForm;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;

    use app\models\FormRegistro;
    use app\models\Users;

    class RegistroController extends Controller
    {
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['logout','registro'],
                    'rules' => [
                        [
                            'actions' => ['logout','registro'],
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
        public function  actionRegistro(){

            $model = new FormRegistro;
            $msg = null;

            if ($model->load(Yii::$app->request->post())){
                if($model->validate()){
                    
                    $table = new Users;
                    $table->username = $model->username;
                    $table->email = $model->email;
                    $table->activate = 1;

                    $table->password = crypt($model->password, Yii::$app->params["salt"]);
            
                    if ($table->insert()){
                        $user = $table->find()->where(["email" => $model->email])->one();
                        $id = urlencode($user->id);
            
                        $model->username = null;
                        $model->email = null;
                        $model->password = null;
                        $model->password_repeat = null;
            
                        $msg = "te has logueado";
                    }
                        else{
                                $msg = "Ha ocurrido un error";
                        }
            
                }else{
                        $model->getErrors();
                    }
            }
            return $this->render("/registro/registro", ["model" => $model, "msg" => $msg]);
        }
    }; 
?>