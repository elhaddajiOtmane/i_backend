<?php
namespace common\models;
//use common\models\User;
use common\models\CompetitionUser;
use common\models\Post;

use common\models\CompetitionExampleImage;
use common\models\CompetitionPosition;
use common\models\Setting;
//use common\models\EventOrganisor;
use common\models\Organization;

use Yii;
use common\models\FileUpload;

class Event extends \yii\db\ActiveRecord
{
    
    const COMMON_NO = 0;
    const COMMON_YES = 1;
    
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 9;
    //const STATUS_COMPLETED = 10;

    
    public $imageFile;
    public $gallaryFile;
    public $deletePhoto;

    //public $competition_id;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'id','category_id','organisor_id','is_paid','created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name','description','image','start_date', 'end_date','place_name','address','latitude','longitude','disclaimer','description'], 'string'],
            [['name','category_id','start_date', 'end_date','organisor_id','is_paid'], 'required','on'=>['create','update']],
            [['imageFile'], 'required','on'=>'create'],

            [['imageFile'], 'file', 'skipOnEmpty' => true],
//            [['gallaryFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, mp4','maxFiles' => 3],
            [['gallaryFile','deletePhoto','imageFile'], 'safe'],
            [['end_date'], 'checkEndDate', 'on' => ['create']],
           
         //   [['competition_id' ], 'required','on'=>'join'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Event Name'),
            'status' => Yii::t('app', 'Status'),
            'start_date' => Yii::t('app', 'Start date'),
            'end_date' => Yii::t('app', 'End date'),
            'organisor_id' => Yii::t('app', 'Organizer'),
            'is_paid' => Yii::t('app', 'Is Paid?'),

            'image' => Yii::t('app', 'Cover image'),
            'imageFile' => Yii::t('app', 'Cover image'),
            'place_name' => Yii::t('app', 'Place name'),
            'category_id' => Yii::t('app', 'Category'),
            
            'gallaryFile' => Yii::t('app', 'Event Gallary'),
            
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            $this->created_by = Yii::$app->user->identity->id;

        } else {
            $this->updated_at = time();
            $this->updated_by = Yii::$app->user->identity->id;

        }

        return parent::beforeSave($insert);
    }
    public function checkEndDate($attribute, $params, $validator)
    {
        if(!$this->hasErrors()){
            if($this->start_date > $this->end_date ){
                $this->addError($attribute, Yii::t('app','End date must be greater than start date'));  
            }
        
            
        }
       
    }

    
    public function getStatusString()
    {
       if($this->status==$this::STATUS_DEACTIVE){
           return 'Unpublish';
       }else if($this->status==$this::STATUS_ACTIVE){
           return 'Publish';    
       }else if($this->status==$this::STATUS_COMPLETED){
         return 'Completed';    
       }
    }


    public function getStatusButton()
    {
        if($this->status==$this::STATUS_ACTIVE){
         //  return 'Active';   
            $currentTime= time();
            if($this->start_date < $currentTime && $this->end_date > $currentTime ){
                return'<button type="button" class="btn btn-sm active_btn">'.Yii::t('app','Active').'</button>';      
                //return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Inactive').'</button>'; 
            }else if($this->start_date > $currentTime){
                
                return'<button type="button" class="btn btn-sm pending_btn">'.Yii::t('app','Upcoming').'</button>'; 
            }else if($this->end_date < $currentTime){
                return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Closed').'</button>'; 
                    
            }
            /*else{
                return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Inactive').'</button>'; 
            }*/


           
        }else if($this->status==$this::STATUS_DELETED){
            
            return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Deleted').'</button>'; 
        }else if($this->status==$this::STATUS_DEACTIVE){
            
            return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Deactive').'</button>'; 
        }else if($this->status==$this::STATUS_COMPLETED){
            
            return'<button type="button" class="btn btn-sm active_btn">'.Yii::t('app','Completed').'</button>';      
        }
        //return'<button type="button" class="btn btn-sm pending_btn">'.Yii::t('app','Pending').'</button>'; 
        //return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Blocked').'</button>'; 
       
    }
    

    /*public function getStatusButton()
    {
        if($this->status==$this::STATUS_ACTIVE){
         //  return 'Active';   
            $currentTime= time();
            if($this->start_date < $currentTime && $this->end_date > $currentTime ){
                return'<button type="button" class="btn btn-sm active_btn">'.Yii::t('app','Active').'</button>';      
                //return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Inactive').'</button>'; 
            }else if($this->start_date > $currentTime){
                return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Upcoming').'</button>'; 
            }else if($this->end_date < $currentTime){
                
                return'<button type="button" class="btn btn-sm pending_btn">'.Yii::t('app','Pending').'</button>'; 
            }else{
                return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Inactive').'</button>'; 
            }


           
        }else if($this->status==$this::STATUS_DELETED){
            
            return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Deleted').'</button>'; 
        }else if($this->status==$this::STATUS_DEACTIVE){
            
            return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Deactive').'</button>'; 
        }else if($this->status==$this::STATUS_COMPLETED){
            
            return'<button type="button" class="btn btn-sm active_btn">'.Yii::t('app','Completed').'</button>';      
        }
        //return'<button type="button" class="btn btn-sm pending_btn">'.Yii::t('app','Pending').'</button>'; 
        //return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Blocked').'</button>'; 
       
    }*/


    public function getStatusDropDownData()
    {
        return array(self::STATUS_ACTIVE => 'Publish', self::STATUS_DEACTIVE => 'Unpublish');
    
    }

    public function getIsDropDownData()
    {
        return array('0' => 'No', '1' => 'Yes');
    
    }

    /*
    
    public function getAwardTypeData()
    {
        return array(self::AWARD_TYPE_PRICE => 'Price', self::AWARD_TYPE_COIN => 'Coin');
    }
    */


    public function getImageUrl()
    {
        $modelFileUpload = new FileUpload();
        return $modelFileUpload->getFileUrl($modelFileUpload::TYPE_EVENT,$this->image);

        
    }

    
    /*
    public function getCompetitionCount()
    {
        return Competition::find()->where(['<>','status',self::STATUS_DELETED])->count();
    }

    public function getCompetitionMediaTypeData()
    {
        $modelSetting = new Setting();
        $resSetting = $modelSetting->getSettingData();
        $mediaType =  [];
        if($resSetting->is_upload_image){
            $mediaType[1] = 'Image';
        }
        if($resSetting->is_upload_video){
            $mediaType[2] = 'Video';
        }
        return $mediaType;
    }*/


    /**
     * RELEATION START
     */
    public function getGallaryImages()
    {
        return $this->hasMany(EventGallaryImage::className(), ['event_id' => 'id']);

    }



    public function getCompetitionUser()
    {
        return $this->hasMany(CompetitionUser::className(), ['competition_id' => 'id']);

    }

    public function getEventOrganisor()
    {
            return $this->hasOne(Organization::className(), ['id'=>'organisor_id']);

    }

    


    public function getPost()
    {
        return $this->hasMany(Post::className(), ['competition_id' => 'id']);

    }

    public function getCompetitionPosition()
    {
        return $this->hasMany(CompetitionPosition::className(), ['competition_id' => 'id'])->orderBy(['competition_winner_position.id' => SORT_ASC]);


    }

    public function getTotalEventCount()
    {
        return Event::find()->where(['<>','status',self::STATUS_DELETED])->count();
    }


}
