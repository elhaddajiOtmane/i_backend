<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Category;
//use backend\models\CategorySearch;
use common\models\Competition;
use common\models\Post;
use common\models\User;
use common\models\Notification;

use common\models\Payment;
use common\models\CompetitionExampleImage;
use common\models\CompetitionPosition;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use common\models\FileUpload;

// new
use common\models\Campaign;
use common\models\Organization;
use common\models\CampaignExampleImage;

/**
 * 
 */

class CampaignController extends Controller
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
                    'winning' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all  models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Campaign();
        $query = $model->find()
        ->where(['<>','status',Competition::STATUS_DELETED]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Campaign();
       
        $modelFileUpload = new FileUpload();
        $datamodel = new Organization();
        $resultChannel = $datamodel->find()->select(['id','name'])->where(['status'=>organization::STATUS_ACTIVE])->all();
        $orgnationdata = ArrayHelper::map($resultChannel,'id','name');

        $modelCategory = new Category();
        $resultCategory = $modelCategory->find()->select(['id','name'])->where(['type'=>Category::TYPE_FUNDRASING])->andWhere(['<>', 'status', Category::STATUS_DELETED])->all();
        $categoryData = ArrayHelper::map($resultCategory,'id','name');
        $model->scenario= 'create';

        $modelCompetitionExampleImage = new CampaignExampleImage();
        
        if ($model->load(Yii::$app->request->post())  ) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->exampleFile = UploadedFile::getInstances($model, 'exampleFile');
            $preImage = $model->cover_image;
        
            if($model->validate()){
                if($model->imageFile){

                    
                    $type =     FileUpload::TYPE_CAMPAGIN;
                    $files = $modelFileUpload->uploadFile($model->imageFile,$type,false);
                    $model->cover_image 		= 	  $files[0]['file']; 
                        
                }
                $model->start_date              = strtotime($model->start_date);
                $model->end_date                = strtotime($model->end_date.' 23:59:59');

                if( $model->save(false)){
                
                    // $inputPosition['competitionId']          =  $model->id;
                    
                    $images =[];
                    foreach ($model->exampleFile as $file) {
                    
                        $type =     FileUpload::TYPE_CAMPAGIN;
                        $files  = $modelFileUpload->uploadFile($file,$type,false);
                        $images[]	= 	  $files[0]['file']; 

                    }
                    if(count($images)>0){
                        $modelCompetitionExampleImage->addPhoto($model->id,$images);
                    }
                    return $this->redirect(['index']);
                }
            }
            
        
        }    
        return $this->render('create', [
            'model' => $model,
            'orgnationdata'=>$orgnationdata,
            'categoryData' =>$categoryData,
        
            
        ]);
    }

   
    //   action update
    public function actionUpdate($id)
    {
        $modelFileUpload = new FileUpload();
        $model = $this->findModel($id);

        $datamodel = new organization();
        $resultChannel = $datamodel->find()->select(['id','name'])->where(['status'=>organization::STATUS_ACTIVE])->all();
        $orgnationdata = ArrayHelper::map($resultChannel,'id','name');
        $modelCategory = new Category();
        $resultCategory = $modelCategory->find()->select(['id','name'])->where(['type'=>Category::TYPE_FUNDRASING])->andWhere(['<>', 'status', Category::STATUS_DELETED])->all();
        $categoryData = ArrayHelper::map($resultCategory,'id','name');
        // $model->scenario= 'update';
        $modelCompaignExampleImage   = new CampaignExampleImage();
        if ($model->load(Yii::$app->request->post())  ) {
            $modelUser = new User();
            $modelUser->checkPageAccess();
    
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->exampleFile = UploadedFile::getInstances($model, 'exampleFile');
            $preImage = $model->cover_image;
            
            if($model->validate()){
                if($model->imageFile){
                    $type =     FileUpload::TYPE_CAMPAGIN;
                    $files = $modelFileUpload->uploadFile($model->imageFile,$type,false);
                    $model->cover_image 		= 	  $files[0]['file'];  
                }
                $model->start_date              = strtotime($model->start_date);
                $model->end_date                = strtotime($model->end_date.' 23:59:59');
                if( $model->save(false)){
                    $s3 = Yii::$app->get('s3');
                    if($model->deletePhoto){

                        $deletePhotoIds=[];
                        foreach($model->deletePhoto as $photoId){
                            if((int)$photoId>0){
                                $resultPhoto = $modelCompaignExampleImage->findOne($photoId);
                                $deletePhotoIds[]=$photoId;
                            }
                        }    
                        
                        if(count($deletePhotoIds)){
                            $modelCompaignExampleImage->deleteAll(['IN','id',$deletePhotoIds]);
                        }
                        
                    }


                    $images =[];
                    foreach ($model->exampleFile as $file) {

                        $type       =     FileUpload::TYPE_CAMPAGIN;
                        $files      =     $modelFileUpload->uploadFile($file,$type,false);
                        $images[]   = 	  $files[0]['file']; 

                    }
                    if(count($images)>0){
                        $modelCompaignExampleImage->addPhoto($model->id,$images);
                    }

                    Yii::$app->session->setFlash('success', "Competition updated successfully");
                    return $this->redirect(['index']);
                }
            }
           
           
        }else{
            $model->start_date              = date('Y-m-d',$model->start_date);
            $model->end_date                = date('Y-m-d',$model->end_date);
            
        }

        return $this->render('update', [
            'model' => $model,
            'orgnationdata'=>$orgnationdata,
            'categoryData' =>$categoryData,
    
        ]);
    
    }

// update end 

    public function actionDelete($id)
    {
        $modelUser = new User();
        $modelUser->checkPageAccess();

        $model= $this->findModel($id);
        $model->status =  $model::STATUS_DELETED;
        if($model->save(false)){

            Yii::$app->session->setFlash('success', "Campaign deleted successfully");

            return $this->redirect(['index']);
        }
        
    }

    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


 

  
}
