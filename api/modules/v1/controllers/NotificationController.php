<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\Notification;
use yii\data\ActiveDataProvider;

class NotificationController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\notification';   
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    
    
    
    public function actions()
	{
		$actions = parent::actions();

		// disable default actions
		unset($actions['create'], $actions['update'], $actions['index'], $actions['delete'], $actions['view']);                    

		return $actions;
    }   
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except'=>['ad-search'],
            'authMethods' => [
                HttpBearerAuth::className()
            ],
        ];
        return $behaviors;
    }
 


    public function actionIndex(){
        
         $userId  = Yii::$app->user->identity->id;
         $model =  new Notification();
         $query = $model->find()->where(['user_id'=>$userId])
         ->joinWith([
            'createdByUser' => function ($query) {
                $query->select(['name', 'username', 'email', 'image','cover_image', 'id', 'is_chat_user_online', 'chat_last_time_online', 'location', 'latitude', 'longitude']);
            }
        ])
           ->orderBy(['id'=>SORT_DESC]);
            

         $dataProvider = new ActiveDataProvider([
                 'query' => $query,
                 'pagination' => [
                     'pageSize' => 200,
                 ]
         ]);
    

        
         $response['message']='Ok';
         $response['notification']=$dataProvider;
        
         return $response;


        /*$userId  = Yii::$app->user->identity->id;
        $model =  new Notification();
        $query = $model->find()->where(['user_id'=>$userId])->orderBy(['id'=>SORT_DESC])->limit(100)->all();
          foreach($query as $key=>$data){
            
            $result[$key]['id'] = $data['id'];
            $result[$key]['type']               = $data['type'];            
            // $id[$key]['reference_id']               = $data['reference_id'];
            $result[$key]['title']               = $data['title'];
            $result[$key]['message']                = $data['message'];
            $result[$key]['read_status']               = $data['read_status'];
            $result[$key]['created_at']              = $data['created_at'];
            $result[$key]['created_by']              = $data['created_by'];
            $result[$key]['created_by_user']               = $model->getUserDetails($data['created_by']);//$data['user_id'];
            $result[$key]['reference']  =  $model->getRefrenceDetails($data['type'] , $data['reference_id']);

          }  

        $response['message']='Ok';
        $response['notification']=$result;
        
        return $response;*/
    }


}



