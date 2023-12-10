<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\User;
use api\modules\v1\models\Event;
use api\modules\v1\models\EventSearch;
use api\modules\v1\models\EventCoupon;
use api\modules\v1\models\EventTicketBooking;
use api\modules\v1\models\EventTicket;
use api\modules\v1\models\FileUpload;
use api\modules\v1\models\EventGallaryImage;
use yii\web\UploadedFile;

use api\modules\v1\models\Payment;
//use api\modules\v1\models\Notification;



/**
 * Controller API
 *
 
 */
class EventController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\event';   
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
            'except'=>[],
            'authMethods' => [
                HttpBearerAuth::className()
            ],
        ];
        return $behaviors;
    }


    public function actionIndex(){
        $model = new EventSearch();
        $result = $model->search(Yii::$app->request->queryParams);
        $response['message'] = Yii::$app->params['apiMessage']['common']['listFound'];
        $response['event']=$result;
        return $response;
    }


    public function actionCoupon(){
        $modelCoupon = new EventCoupon();
        $currentTime = time();
        $query = $modelCoupon->find()->where(['event_coupon.status'=>EventCoupon::STATUS_ACTIVE]);
        $query->andwhere(['>','event_coupon.expiry_date',$currentTime]);
        
        $result = $query->all();
        
        $response['message'] = Yii::$app->params['apiMessage']['common']['listFound'];
        $response['coupon']=$result;
        return $response;
    }

    
    public function actionView($id)
    {
        $model = new Event();
        $result = $model->find()->where(['event.id'=>$id])
        ->one();
        $response['message'] = Yii::$app->params['apiMessage']['post']['listFound'];
        $response['event'] = $result;
        return $response;

    }

    public function actionBuyTicket()
    {
        $userId                 = Yii::$app->user->identity->id;
       
        $model                  =     new EventTicketBooking();
        $modelEventTicket       =   new EventTicket();
        $modelEvent             =   new Event();

        
        
        $modelUser   =   new User();
        $resultUser = $modelUser->findOne($userId);
       
        $model->scenario ='buyTicket';
        
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if(!$model->validate()) {
                $response['statusCode']=422;
                $response['errors']=$model->errors;
                return $response;
            }
            $currentTime=time();
           $eventId                 =  @(int) $model->event_id;
           $eventTicketId           =  @(int)$model->event_ticket_id;
           $resultEvent             = $modelEvent->find()->where(['id'=>$eventId,'status'=>Event::STATUS_ACTIVE])->one();
           $resultEventTicket       = $modelEventTicket->find()->where(['id'=>$eventTicketId,'status'=>EventTicket::STATUS_ACTIVE])->one();

          // print_r($resultEventTicket);

          
           
           if(!$resultEvent){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['noRecord'];
                $response['errors']=$errors;
                return $response;
            
           }

           if($currentTime > $resultEvent->end_date){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['eventClosed'];
                $response['errors']=$errors;
                return $response;
        
            }

          

            if(!$resultEventTicket){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['noRecord'];
                $response['errors']=$errors;
                return $response;
            
           }

           if($model->ticket_qty > $resultEventTicket->available_ticket){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['seatNotAvailable'];
                $response['errors']=$errors;
                return $response;
        
            }

             #region check availabe balance
            
             //if($model->is_paid==Order::IS_PAID_YES){
            foreach($model->payments as $payment){
                if($payment['payment_mode']==Payment::PAYMENT_MODE_WALLET && $payment['amount'] > $resultUser->available_balance ){
                    $response['statusCode']=422;
                    $errors['message'][] = Yii::$app->params['apiMessage']['event']['amountNotAvailable'];
                    $response['errors']=$errors;
                    return $response;
    

                }

            }
            // }           
             #endregion



           
            

           
            //resultUser
            
            //$modelLiveTvSubscriber->user_id       =   $userId;
           // $modelLiveTvSubscriber->live_tv_id    =   $liveTvId;
            //$modelLiveTvSubscriber->paid_coin     =   $resultLiveTv->paid_coin;
           $model->user_id       =   $userId;     

            if($model->save()){

                $resultEventTicket->available_ticket =  $resultEventTicket->available_ticket-$model->ticket_qty;
                $resultEventTicket->save();



                foreach($model->payments as $payment){
                    /*if($payment['payment_mode']==Payment::PAYMENT_MODE_WALLET && $payment['amount'] > $resultUser->available_balance ){

                        //$payment['amount']
                            $response['statusCode']=422;
                            $errors['message'][] = Yii::$app->params['apiMessage']['event']['amountNotAvailable'];
                            $response['errors']=$errors;
                            return $response;
            
        
                        }
        
                    }*/

                    $modelPayment          = new Payment();
                    $modelPayment->type                 =  Payment::TYPE_PRICE;
                    $modelPayment->transaction_type     =  Payment::TRANSACTION_TYPE_DEBIT;
                    $modelPayment->payment_type         =  Payment::PAYMENT_TYPE_EVENT_TICKET;
                    $modelPayment->payment_mode         =  $payment['payment_mode'];
                    $modelPayment->amount               =  $payment['amount'];
                    $modelPayment->event_ticket_booking_id           =  $model->id;
                    $modelPayment->transaction_id        =  $payment['transaction_id'];
                    $modelPayment->save(false);
                    if($payment['payment_mode']==Payment::PAYMENT_MODE_WALLET){

                        $resultUser = $modelUser->findOne($userId);
                        $resultUser->available_balance   = $resultUser->available_balance - $payment['amount'];
                        $resultUser->save(false);

                    }


                }
                
                $response['message']=Yii::$app->params['apiMessage']['event']['buyTicketSuccessfully'];
                $response['id']=$model->id;
                return $response; 
            }else{

                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['actionFailed'];
                $response['errors']=$errors;
                return $response;
            
            

            }

            
        }

       
        
    }


    public function actionMyBookedEvent(){
        $model = new EventSearch();
        $result = $model->searchMyBookedEvent(Yii::$app->request->queryParams);
        $response['message'] = Yii::$app->params['apiMessage']['common']['listFound'];
        $response['eventBooking']=$result;
        return $response;
    }

    
    public function actionCancelTicketBooking()
    {
        $userId                 = Yii::$app->user->identity->id;
       
        $model                  =     new EventTicketBooking();
        $modelEventTicket       =   new EventTicket();
        $modelEvent             =   new Event();

        
        
        $modelUser   =   new User();
       // $resultUser = $modelUser->findOne($userId);
       
        $model->scenario ='cancelBooking';
        
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if(!$model->validate()) {
                $response['statusCode']=422;
                $response['errors']=$model->errors;
                return $response;
            }
            
            $modelEventTicketBooking = $model->findOne($model->id);
           

              
           if(!$modelEventTicketBooking){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['noRecord'];
                $response['errors']=$errors;
                return $response;
            }

                
            if($modelEventTicketBooking->user_id !=$userId){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['notAllowed'];
                $response['errors']=$errors;
                return $response;
            }

            if($modelEventTicketBooking->status ==EventTicketBooking::STATUS_CANCELLED){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['alreadyCancelled'];
                $response['errors']=$errors;
                return $response;
            }

            $resultEvent = $modelEvent->findOne($modelEventTicketBooking->event_id);
            
            $currentTime=time();

            if($currentTime > $resultEvent->start_date){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['canNotCancelled'];
                $response['errors']=$errors;
                return $response;
            }

            $modelEventTicketBooking->status = EventTicketBooking::STATUS_CANCELLED;
            if($modelEventTicketBooking->save()){
                $paidAmount = $modelEventTicketBooking->paid_amount;
                $resultEventTicket = $modelEventTicket->findOne($modelEventTicketBooking->event_ticket_id);
                $resultEventTicket->available_ticket=  $resultEventTicket->available_ticket+ $modelEventTicketBooking->ticket_qty;
                $resultEventTicket->save();

                /// refund amount
                $resultUser = $modelUser->findOne($userId);
                $resultUser->available_balance   = $resultUser->available_balance + $paidAmount;
                if($resultUser->save(false)){

                    $modelPayment          = new Payment();
                    $modelPayment->type                     =  Payment::TYPE_PRICE;
                    $modelPayment->transaction_type         =  Payment::TRANSACTION_TYPE_CREDIT;
                    $modelPayment->payment_type             =  Payment::PAYMENT_TYPE_EVENT_TICKET_REFUND;
                    $modelPayment->payment_mode             =  Payment::PAYMENT_MODE_WALLET;
                    $modelPayment->amount                   =  $paidAmount;
                    $modelPayment->event_ticket_booking_id  =  $model->id;
                    $modelPayment->save(false);
                }

                $response['message']=Yii::$app->params['apiMessage']['event']['cancelTicketSuccessfully'];
                return $response; 


            }else{
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['actionFailed'];
                $response['errors']=$errors;
                return $response;

            }

            
        }

       
        
    }


    public function actionGiftTicket()
    {
        $userId                 = Yii::$app->user->identity->id;
       
        $model                  =     new EventTicketBooking();
        $modelEventTicket       =   new EventTicket();
        $modelEvent             =   new Event();

        
        
        $modelUser   =   new User();
       // $resultUser = $modelUser->findOne($userId);
       
        $model->scenario ='giftTicket';
        
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if(!$model->validate()) {
                $response['statusCode']=422;
                $response['errors']=$model->errors;
                return $response;
            }
            
            $modelEventTicketBooking = $model->findOne($model->id);
           

              
           if(!$modelEventTicketBooking){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['noRecord'];
                $response['errors']=$errors;
                return $response;
            }

                
            if($modelEventTicketBooking->user_id !=$userId){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['notAllowed'];
                $response['errors']=$errors;
                return $response;
            }

            if($modelEventTicketBooking->status != EventTicketBooking::STATUS_PURCHASED){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['canNotGift'];
                $response['errors']=$errors;
                return $response;
            }
            if($modelEventTicketBooking->gifted_to){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['alreadyGifted'];
                $response['errors']=$errors;
                return $response;
            }


            $resultEvent = $modelEvent->findOne($modelEventTicketBooking->event_id);
            
            $currentTime=time();

            if($currentTime > $resultEvent->start_date){
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['event']['canNotGift'];
                $response['errors']=$errors;
                return $response;
            }

            $modelEventTicketBooking->gifted_to = $model->gifted_to;
            if($modelEventTicketBooking->save()){
                
                $response['message']=Yii::$app->params['apiMessage']['event']['ticketGifted'];
               
                return $response; 


            }else{
                $response['statusCode']=422;
                $errors['message'][] = Yii::$app->params['apiMessage']['common']['actionFailed'];
                $response['errors']=$errors;
                return $response;

            }

            
        }

       
        
    }

    public function actionCreateEvent(){
        $model = new Event();
        $userId = Yii::$app->user->identity->id;
        
        $model->scenario ='create';
        $modelFileUpload = new FileUpload();
        $modelEventGallaryImage = new EventGallaryImage();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }
        // echo "<pre>";
        // print_r($model->gallaryFile);
        // exit("dndkn");
        // $model->user_id = $userId;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        // $model->imageFile = UploadedFile::getInstanceByName('imageFile'); 
        // $model->gallaryFile = UploadedFile::getInstanceByName('gallaryFile');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }

        if($model->imageFile){
            $model->image 		= 	  $model->imageFile;
        }
        $model->start_date              = strtotime($model->start_date);
        $model->end_date                = strtotime($model->end_date);
        $images =[];
        if($model->gallaryFile){        
            $galleryImg		= 	  $model->gallaryFile;          
            $images = explode(',', $galleryImg);
        }
        $model->created_by_source = Event::EVENT_CREATED_SOURCE_USER;
        if($model->save(false)){     
        if(count($images)>0){
            $modelEventGallaryImage->addPhoto($model->id,$images);
        }

            $response['message']='Event created successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event not create successfully";
            $response['errors']=$errors;
            return $response; 
        }   
    }

    public function actionUpdate($id){
        // Yii::$app->getRequest()
        $model =  Event::find()->where(['id'=>$id])->one();//new Event();
        $userId = Yii::$app->user->identity->id;
        $model =  $this->findModel($id);
        $model->scenario ='create';
        $modelFileUpload = new FileUpload();
        $modelEventGallaryImage = new EventGallaryImage();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        // $model->imageFile = UploadedFile::getInstanceByName('imageFile'); 
        // $model->gallaryFile = UploadedFile::getInstanceByName('gallaryFile');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }

        if($model->imageFile){
            $model->image 		= 	  $model->imageFile;
        }
        $model->start_date              = strtotime($model->start_date);
        $model->end_date                = strtotime($model->end_date);
        $images =[];
        if($model->gallaryFile){        
            $galleryImg		= 	  $model->gallaryFile;          
            $images = explode(',', $galleryImg);
        }
        $model->created_by_source = Event::EVENT_CREATED_SOURCE_USER;
        if($model->save(false)){     
        if(count($images)>0){
            $modelEventGallaryImage->addPhoto($model->id,$images);
        }

            $response['message']='Event updated successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event updation failed";
            $response['errors']=$errors;
            return $response; 
        }   
    }

    public function actionCreateTicket(){
        $model = new EventTicket();
        $userId = Yii::$app->user->identity->id;
        
        $model->scenario ='create';
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }
        $model->available_ticket	= $model->limit;
        $model->created_at              = strtotime("now");
       if($model->save(false)){        

            $response['message']='Event ticket created successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event ticket not create successfully";
            $response['errors']=$errors;
            return $response; 
        }   
    }

    public function actionUpdateTicket(){
         $id=  Yii::$app->request->post('id');
        $model =  EventTicket::find()->where(['id'=>$id])->one();
        // $model = new EventTicket();
        if(empty($model)){
            $response['statusCode']=422;
            $errors['message'][] = "Event ticket id not found";
            $response['errors']=$errors;
            return $response;
        }
        $userId = Yii::$app->user->identity->id;
        $model->scenario ='updateTicket';
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }
        
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }
        $model->available_ticket	= $model->limit;
        $model->updated_at              = strtotime("now");
       if($model->save(false)){        

            $response['message']='Event ticket updated successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event ticket updation failed";
            $response['errors']=$errors;
            return $response; 
        }   
    }
    
    
    public function actionTicketList(){
        $model =  new EventTicket();
        $modelRes= $model->find()->where(['status'=>EventTicket::STATUS_ACTIVE])->orderBy(['id'=>SORT_DESC])->all();
        $response['message']='ok';
        $response['ticketEventList']=$modelRes;
        return $response;
    }

    public function actionList(){
        $model =  new EventSearch();
        $currentTime = time();
        $modelRes= $model->find()->where(['status'=>Event::STATUS_ACTIVE])->andwhere(['>','event.end_date',$currentTime])->orderBy(['id'=>SORT_DESC])->all();
        $response['message']='ok';
        $response['eventList']=$modelRes;
        return $response;
    }


    
    public function actionCreateCoupon(){
        $model = new EventCoupon();
        $userId = Yii::$app->user->identity->id;
        
        $model->scenario ='create';
        $modelFileUpload = new FileUpload();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }

        if($model->imageFile){
            $model->image 		= 	  $model->imageFile;
        }
        $model->expiry_date              = strtotime($model->expiry_date);
        $model->created_at                = strtotime("now");
        $model->created_by = $userId;
        if($model->save(false)){     
            $response['message']='Event Coupon created successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event Coupon not create successfully";
            $response['errors']=$errors;
            return $response; 
        }   
    }

    public function actionUpdateCoupon(){
        $id=  Yii::$app->request->post('id');
        $model = EventCoupon::find()->where(['id'=>$id])->one();
        // $model = new EventCoupon();
        if(empty($model)){
            $response['statusCode']=422;
            $errors['message'][] = "Event Coupon id not found";
            $response['errors']=$errors;
            return $response;
        }
        $userId = Yii::$app->user->identity->id;
        
        $model->scenario ='update';
        $modelFileUpload = new FileUpload();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
        
            return $response;
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!$model->validate()) {
            $response['statusCode']=422;
            $response['errors']=$model->errors;
            return $response;
        }

        if($model->imageFile){
            $model->image 		= 	  $model->imageFile;
        }
        $model->expiry_date              = strtotime($model->expiry_date);
        $model->updated_at                = strtotime("now");
        $model->updated_by = $userId;
        if($model->save(false)){     
            $response['message']='Event Coupon updated successfully';
            return $response; 
        }else{
            $response['statusCode']=422;
            $errors['message'][] = "Event Coupon not updated successfully";
            $response['errors']=$errors;
            return $response; 
        }   
    }


    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}


