<?php
namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Event;
use common\models\Payment;
use common\models\EventTicket;
use app\models\User;


/**
 * This is the model class 
 *
 */
class EventTicketBooking extends \yii\db\ActiveRecord
{
    const STATUS_PURCHASED = 1;
    const STATUS_CANCELLED = 9;
    const STATUS_COMPLETED = 10;

    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_ticket_booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            
            [['id','event_id','event_ticket_id','user_id','ticket_qty','created_at'], 'integer'],
            [['coupon'], 'string'],
            [['coupon_discount_value','ticket_amount','paid_amount'], 'number'],
            
            

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => Yii::t('app', 'Event'),
            'status' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User'),
            'created_at' => Yii::t('app', 'Booked At'),
            'event_ticket_id' => Yii::t('app', 'Ticket'),
            
            
            
            
            
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
        }else{
            $this->updated_at = time();
        }
        return parent::beforeSave($insert);
    }

    
    public function getStatus()
    {
       if($this->status==$this::STATUS_CANCELLED){
           return 'Cancelled';
       }else {
           return 'Booked';    
       }
    }

    public function getStatusButton()
    {
        if($this->status==$this::STATUS_CANCELLED){
            return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Cancelled').'</button>'; 
       
           
        }else {
            
            return'<button type="button" class="btn btn-sm active_btn">'.Yii::t('app','Booked').'</button>';     
        }
        //return'<button type="button" class="btn btn-sm pending_btn">'.Yii::t('app','Pending').'</button>'; 
        //return'<button type="button" class="btn btn-sm expired_btn">'.Yii::t('app','Blocked').'</button>'; 
       
    }
  
    public function getTicket()
    {
        return $this->hasOne(EventTicket::className(), ['id' => 'event_ticket_id']);

    }
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);

    }
    public function getPayment()
    {
        return $this->hasMany(Payment::className(), ['event_ticket_booking_id' => 'id']);

    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);

    }
   

   



    

}
