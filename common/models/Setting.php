<?php
namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use yii\base\ErrorException;

/**
 * This is the model class for table "countryy".
 *
 */
class Setting extends \yii\db\ActiveRecord
{

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['id','each_view_coin','min_coin_redeem','is_photo_post','is_video_post','is_stories','is_story_highlights','is_chat','is_audio_calling','is_video_calling','is_live','is_clubs','is_competitions','is_events','is_staranger_chat','is_profile_verification','is_light_mode_switching','is_watch_tv','is_podcasts','is_gift_sending','is_polls','is_dating','is_fund_raising','is_family_link_setup','is_post_promotion','is_location_sharing','is_gift_share','is_contact_sharing','is_photo_share','is_video_share','is_files_share','is_gift_share','is_audio_share','is_audio_share','is_drawing_share','is_user_profile_share','is_club_share','is_reply','is_forward','is_star_message','is_events_share','is_chat_gpt','is_coupon','is_reel','is_job','is_shop','is_live_user','is_offer','ads_auto_approve','is_photo_video_edit'],'integer'],

 
            [['min_widhdraw_price','per_coin_value','available_coin','commission_on_gift'], 'number'],
            [['email','phone','site_name','facebook','youtube','twitter','linkedin','pinterest','instagram','in_app_purchase_id','release_version','site_url','user_p_id','maximum_video_duration_allowed','free_live_tv_duration_to_view','latest_app_download_link','disclaimer_url','privacy_policy_url','terms_of_service_url','giphy_api_key','agora_api_key','agora_app_certificate','google_map_api_key','interstitial_ad_unit_id_for_android','interstitial_ad_unit_id_for_IOS','reward_interstitl_ad_unit_id_for_android','reward_interstitial_ad_unit_id_for_IOS','banner_ad_unit_id_for_android','banner_ad_unit_id_for_IOS','fb_interstitial_ad_unit_id_for_android','fb_interstitial_ad_unit_id_for_IOS','fb_reward_interstitial_ad_unit_id_for_android','fb_reward_interstitial_ad_unit_id_for_IOS','network_to_use','stripe_publishable_key','stripe_secret_key','paypal_merchant_id','paypal_public_key','paypal_private_key','razorpay_api_key','moments_name','theme_color','theme_font','theme_light_background_color','theme_light_text_color','theme_dark_background_color','theme_dark_text_color','website_name','website_url','chat_gpt_key','imgly_key'], 'string', 'max' => 256],
            


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'site_name' => Yii::t('app', 'Site Name'),
            'each_view_coin' => Yii::t('app', 'Post View Coin'),
            'user_p_id'=> Yii::t('app', 'Envento purcahse code'),
            'razorpay_api_key'=> Yii::t('app', 'Razorpay api key'),
            'paypal_merchant_id'=> Yii::t('app', 'Braintree  Merchant Id'),
            'paypal_public_key'=> Yii::t('app', 'Braintree Public key'),
            'paypal_private_key'=> Yii::t('app', 'Braintree Private key'),
            'agora_api_key'=> Yii::t('app', 'Agora App ID'),
            
            'is_photo_post' => Yii::t('app', 'Photo Post'),
            'is_video_post' => Yii::t('app', 'Video Post'),
            'is_stories' => Yii::t('app', 'Stories'),
            'is_story_highlights' => Yii::t('app', 'Story Highlights'),
            'is_chat' => Yii::t('app', 'Chat'),
            'is_audio_calling' => Yii::t('app', 'Audio Calling'),
            'is_video_calling' => Yii::t('app', 'Video Calling'),
            'is_live' => Yii::t('app', 'Live'), 
            'is_clubs' => Yii::t('app', 'Clubs'),
            'is_competitions' => Yii::t('app', 'Competitions'),
            'is_events' => Yii::t('app', 'Events'),
            'is_staranger_chat' => Yii::t('app', 'Staranger Chat'),
            'is_profile_verification' => Yii::t('app', 'Profile Verification'),
            'is_light_mode_switching'=>Yii::t('app', 'Light Mode Switching'),
            'is_watch_tv' => Yii::t('app', 'Watch Tv'),
            'is_podcasts' => Yii::t('app', 'Podcasts'),
            'is_gift_sending' => Yii::t('app', 'Gift Sending'),

            
            'is_contact_sharing' => Yii::t('app', 'Contact Share'),
            'is_location_sharing' => Yii::t('app', 'Location Share'),
            'is_photo_share' => Yii::t('app', 'Photo Share'),
            'is_video_share' => Yii::t('app', 'Video Share'),
            'is_files_share' => Yii::t('app', 'Files Share'),
            'is_gift_share' => Yii::t('app', 'Gif Share'),
            'is_audio_share' => Yii::t('app', 'Audio Share'),
            'is_drawing_share' => Yii::t('app', 'Drawing Share'),
            'is_user_profile_share' => Yii::t('app', 'User Profile Share'),
            'is_club_share' => Yii::t('app', 'Club Share'),
            'is_events_share' => Yii::t('app', 'Events Share'),
            'is_reply' => Yii::t('app', 'Reply'),
            'is_forward' => Yii::t('app', 'Forward'),
            'is_star_message' => Yii::t('app', 'Star Message'),

            'is_polls' => Yii::t('app', 'Polls'),
            'is_dating' => Yii::t('app', 'Dating'),
            'is_fund_raising' => Yii::t('app', 'Fund Raising'),
            'is_family_link_setup' => Yii::t('app', 'Family links Setup'),
            'is_post_promotion' => Yii::t('app', 'Post Promotion'),
            'is_chat_gpt' => Yii::t('app', 'Chat GPT'),
            
            'moments_name' => Yii::t('app', 'Moments name'),
            'theme_color' => Yii::t('app', 'Theme color'),
            'theme_font' => Yii::t('app', 'Theme Font'),
            'theme_light_background_color' => Yii::t('app', 'Theme light background color'),
            'theme_light_text_color' => Yii::t('app', 'Theme light text color'),
            'theme_dark_background_color' => Yii::t('app', 'Theme dark background color'),
            'theme_dark_text_color' => Yii::t('app', 'Theme dark text color'),
            'chat_gpt_key' => Yii::t('app', 'Chat Gpt Key'),
            'is_coupon' => Yii::t('app', 'Coupon'),
            'is_reel' => Yii::t('app', 'Reel'),
            'is_job' => Yii::t('app', 'Job'),
            'is_shop' => Yii::t('app', 'Shop'),
            'is_live_user' => Yii::t('app', 'Live User'),
            'is_offer' => Yii::t('app', 'Offer'),
            'ads_auto_approve' => Yii::t('app', 'Ads Auto Approve'),
          

            
            

            
        ];
    }
    public function getEnableDisableDropDownData()
    {
        return array(1 => 'Enable', 0 => 'Disable');
    }

    public function getSettingData()
    {
        return $this->find()->orderBy(['id'=>SORT_DESC])->one();
    }
    public function updateSettingData()
    {
        $res= $this->find()->orderBy(['id'=>SORT_DESC])->one();
        $res->site_url = Yii::$app->params['siteUrl'];
        $res->save(false);
    }

    public function getGraphSetting(){
		//nulled
		return true;
    }

    
    
    public function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        
        curl_close($curl);

        return $result;
    }
    

    public function getNetworkUseDropDownData()
    {
        return array(1 => 'Facebook', 2 => 'Google');
    }

    public function getFontDropDownData()
    {
        return array('Arial' => 'Arial', 'Verdana' => 'Verdana' , 'Tahoma' => 'Tahoma' , 'Georgia'=>'Georgia');
    }

    public function getAutoAdsDropDownData()
    {
        return array(1 => 'Yes', 0 => 'No');
    }
}
