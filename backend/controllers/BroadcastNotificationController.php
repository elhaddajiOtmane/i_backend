<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use backend\models\UserSearch;
use backend\models\ChangePassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\Notification;
use common\models\BroadcastNotification;
use backend\models\BroadcastNotificationSearch;
use common\models\BroadcastNotificationUser;



/**
 * 
 */
class BroadcastNotificationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {     
        $this->enableCsrfValidation = false;     
        return parent::beforeAction($action);
     }

    /**
     * Lists all  models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchBroadcast(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    public function actionIndex()
    {
        $searchModel = new BroadcastNotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionBroadcastUser($id)
    {
        $BroadcastNotificationUser = new BroadcastNotificationUser();
     //   $dataProvider = $searchModel->searchBroadcast(Yii::$app->request->queryParams);

        $query = BroadcastNotificationUser::find()
        ->where(['broadcast_notification_id'=>$id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            
        ]);

      


        return $this->render('broadcast-user', [
            'searchModel' => [],
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Creates a new Countryy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        $searchModel = new UserSearch();

       $model = new User();

      

        $query = User::find()
        ->where(['role'=>USER::ROLE_CUSTOMER])
        ->andWhere(['<>','status',USER::STATUS_DELETED]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            
        ]);

        
       // Yii::$app->request->queryParams=[];
     //   $dataProvider = $searchModel->searchBroadcast(Yii::$app->request->queryParams);


            if(Yii::$app->request->post()){
                $modelUser = new User();
                $modelUser->checkPageAccess();
                $postData = Yii::$app->request->post();
                $title          = $postData['notification_title'];
                $messageBody               = $postData['notification_message'];
                
                $selectedRows = $postData['selectedRows'];

                $userIdsAll = explode(',',$selectedRows);
                //print_r($userIds);

                $modelNotification = new Notification();
                $notificationInput = [];
                $notificationData =  Yii::$app->params['pushNotificationMessage']['broadcastNotification'];
               
                $notificationData['title'] =  $title;
                $notificationData['body'] =  $messageBody;

                $userIdsChuck =array_chunk($userIdsAll, 100);
          
                foreach($userIdsChuck as $userIds){
                     $notificationInput['userIds'] = $userIds;
                     $notificationInput['notificationData'] = $notificationData;
                     $notificationInput['isSaveList'] = false;
                     $modelNotification->createNotification($notificationInput);

                }
                
                $modelBroadcastNotification = new BroadcastNotification();
                $modelBroadcastNotification->title = $title;
                $modelBroadcastNotification->message_body = $messageBody;
                $modelBroadcastNotification->total_user = count($userIdsAll);
                if($modelBroadcastNotification->save()){
                    
                    $values=[];
                    foreach($userIdsAll as $userId){
                        //  print_r($location);
                          $dataInner=[]; 
                          $dataInner['broadcast_notification_id']   =    $modelBroadcastNotification->id;
                          $dataInner['user_id']                     =    $userId;
                          
                          $values[]=$dataInner;
              
                      }   
                      if(count($values)>0){
                         Yii::$app->db
                         ->createCommand()
                         ->batchInsert('broadcast_notification_user', ['broadcast_notification_id','user_id'],$values)
                         ->execute();
                     }
                     Yii::$app->session->setFlash('success', "Broadcast notification sent successfully");
                     return $this->redirect(['index']);


                }else{

                    Yii::$app->session->setFlash('error', "Broadcast notification has sent successfully");
                    return $this->redirect(['index']);
                }


               
            }
        

        return $this->render('create-broadcast', [
            'searchModel' =>[],
            'dataProvider' => $dataProvider,
        ]);
        
        /*$model = new User();
        $modelCountry = new Country();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
           // $model->image  = $model->upload();
           if($model->imageFile){
				
                $microtime 			= 	(microtime(true)*10000);
                $uniqueimage		=	$microtime.'_'.date("Ymd_His").'_'.substr(md5($microtime),0,10); 
                $imageName 			=	$uniqueimage;
                $model->image 		= 	$imageName.'.'.$model->imageFile->extension; 
                $imagePath 			=	Yii::$app->params['pathUploadUser'] ."/".$model->image;
                $imagePathThumb 	=	Yii::$app->params['pathUploadUserThumb'] ."/".$model->image;
                $imagePathMedium 	=	Yii::$app->params['pathUploadUserMedium'] ."/".$model->image;
                $model->imageFile->saveAs($imagePath,false);
                
                
                Image::thumbnail($imagePath, 500, 500)
                        ->save($imagePathMedium, ['quality' => 100]);

                Image::thumbnail($imagePath, 120, 120)
                        ->save($imagePathThumb, ['quality' => 100]);

            
            }
            
            if($model->save()){
           
            Yii::$app->session->setFlash('success', "USer created successfully");
            return $this->redirect(['index']);
            }
        }

     
        $countryData = $modelCountry->getCountryDropdown();
       

        return $this->render('create', [
            'model' => $model,
            'countryData'=> $countryData 
        ]);*/
    }

   

    /**
     * Deletes an existing Countryy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelUser = new User();
        $modelUser->checkPageAccess();

        $userModel= $this->findModel($id);
        $userModel->status =  USER::STATUS_DELETED;
        $userModel->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Countryy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countryy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
