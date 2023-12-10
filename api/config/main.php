<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [       
        'pushNotification' => [
            'class' => 'api\components\PushNotification'
        ],
        
        'user' => [
            'identityClass' => 'api\modules\v1\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
                
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'xxxxxxx',
        ],
        'response'  =>  [
            
            'format'        =>  'json',
            'class'         =>  'yii\web\Response',
            'on beforeSend' =>  function ($event) {
            $response = $event->sender;

            $response->headers->set('Access-Control-Allow-Origin', '*'); // Allow all domains, change to your specific domains if needed
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', '*');
            $response->headers->set('Access-Control-Allow-Credentials', 'false');


                if ($response->data !== null && $response->statusCode != 401 && $response->statusCode != 404 && $response->statusCode != 405 && $response->statusCode != 500  ) {
                //if ($response->data !== null && $response->statusCode != 401 && $response->statusCode != 404 && $response->statusCode != 405   ) {
                    $message= isset($response->data['message'])? $response->data['message']:'';
                    $response->statusCode=  $statusCode=isset($response->data['statusCode'])?$response->data['statusCode']:$response->statusCode;
                    if(isset($response->data['message']))
                    unset($response->data['message']);
                    if(isset($response->data['statusCode']))
                    unset($response->data['statusCode']);

                    $response->data = [
                        //'isSuccessful'      =>  $response->isSuccessful,
                        //'isOk'              =>  $response->isOk,
                        //'isServerError'     =>  $response->isServerError,
                        'status'            =>  $statusCode,
                        'statusText'        =>  $response->statusText,
                        'message'           =>  $message,
                        'data'              =>  $response->data,                                    
                    ];                
                }
            },

        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/photo',
                    'extraPatterns' => [
                       
                        'POST login' 		    => 'login',
                       
                    
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/country',
                    'extraPatterns' => [
                        
                        'GET search-location'  => 'search-location',
                    
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'extraPatterns' => [
                        'GET test' 		            => 'test',
                        'POST login' 		        => 'login',
                        'POST logout' 		        => 'logout',
                        'POST login-social' 		=> 'login-social',
                        'POST forgot-password' 	    => 'forgot-password',
                        'POST register' 		    => 'register',
                        'GET profile'    		    => 'profile',
                        'POST profile-update'       => 'profile-update',
                        'POST update-token'       => 'update-token',
                        'POST update-location'       => 'update-location',
                        'POST update-password'       => 'update-password',
                        'POST update-payment-detail' =>'update-payment-detail',
                        'POST update-profile-image'       => 'update-profile-image',
                        'GET nearest-user'          => 'nearest-user',
                        'POST update-mobile'          => 'update-mobile',
                        'POST verify-otp'          => 'verify-otp',
                        'POST change-mobile'          => 'change-mobile',
                        'POST search-user'          => 'search-user',
                        'GET find-friend'          => 'find-friend',
                        'POST report-user'  => 'report-user', 
                        'POST verify-registration-otp' => 'verify-registration-otp',
                        'POST check-username' => 'check-username',

                        'POST forgot-password-request' 	=> 'forgot-password-request',
                        'POST forgot-password-verify-otp' 	=> 'forgot-password-verify-otp',
                        'POST set-new-password' 	=> 'set-new-password',
                        'POST resend-otp'           => 'resend-otp',
                        'GET sugested-user'          => 'sugested-user',
                        'POST push-notification-status'           => 'push-notification-status',
                        'POST delete-account'           => 'delete-account',
                        'POST add-setting'           => 'add-setting',
                        'POST profile-visibility'    => 'profile-visibility',
                        'POST view-counter' => 'view-counter',
                        'POST update-profile-cover-image' => 'update-profile-cover-image',
                        'POST register-phonenumber'     => 'register-phonenumber',
                        'POST login-with-phonenumber'   => 'login-with-phonenumber',
                        'POST login-phonenumber-without-otp' => 'login-phonenumber-without-otp'   
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/category',
                    'extraPatterns' => [
                        'GET live-tv'               => 'live-tv',
                        'GET gift'                  => 'gift',
                        'GET event'                  => 'event',
                        'GET reel-audio'             => 'reel-audio',
                        'GET podcast'                => 'podcast',
                        'GET podcast-show'            => 'podcast-show',
                        'GET campaign'               =>'campaign',
                        'GET poll'                   =>  'poll',
                        'GET business-category'      =>  'business-category',
                        'GET all'                   =>  'all',
                        'GET job'                   =>  'job',

                       
                    
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/state',
                    'extraPatterns' => [
                       
                    
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/faq',
                    'extraPatterns' => [
                       
                    
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/city',
                    'extraPatterns' => [
                       
                    
                    ],
                ],
                
                
                
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/ad',
                    'extraPatterns' => [
                        'POST upload-image'       => 'upload-image',
                        'GET my-ad'               => 'my-ad',
                        'POST update-status'       => 'update-status',
                        'POST ad-search'       => 'ad-search',
                        'POST report-ad'       => 'report-ad',
                        
                    ],
                ],
                // [
                //     'class' => 'yii\rest\UrlRule',
                //     'controller' => 'v1/package',
                //     'extraPatterns' => [],
                // ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/favorite',
                    'extraPatterns' => [
                        'POST add-favorite'       => 'add-favorite',
                        'POST remove-favorite'       => 'remove-favorite'
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/payment',
                    'extraPatterns' => [
                        'POST package-subscription'     => 'package-subscription',
                        'POST withdrawal'               => 'withdrawal',
                        'GET withdrawal-history'        => 'withdrawal-history',
                        'GET payment-history'           => 'payment-history',
                        'POST redeem-coin'              => 'redeem-coin',
                        'POST payment-intent'            => 'payment-intent',
                        'POST paypal-payment'            => 'paypal-payment',
                        'GET paypal-client-token'        => 'paypal-client-token',
                        'POST ad-package-subscription'     => 'ad-package-subscription',
                        'POST banner-ad'     => 'banner-ad',
                        'POST feature-ad'     => 'feature-ad',
                        
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/follower',
                    'extraPatterns' => [
                        'POST unfollow'  => 'unfollow',
                        'POST follow-multiple'  => 'follow-multiple',
                        'GET my-follower'  => 'my-follower',
                        'GET my-following-live'  => 'my-following-live',
                        'GET my-following'  => 'my-following',
                        'POST request'  => 'request',
                        'POST cancel-request'  => 'cancel-request',
                        'POST accept-request'  => 'accept-request',
                        'POST delete-request'  => 'delete-request',
                        'GET my-received-following-request'  => 'my-received-following-request',
                        'GET my-following-request'  => 'my-following-request',
                        
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/message',
                    'extraPatterns' => [
                        'GET message-group'            => 'message-group',
                        'GET message-history'            => 'message-history',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/audio',
                    'extraPatterns' => [
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/post',
                    'extraPatterns' => [
                        'GET my-post'            => 'my-post',  
                        'GET search-post'        => 'search-post',  
                        'GET story-post'         => 'story-post',  
                        'GET my-story-post'      => 'my-story-post',  
                        'GET search-post-following-user'        => 'search-post-following-user',  
                        'GET my-post-mention-user'            => 'my-post-mention-user',  
                        'POST like'              => 'like',  
                        'POST unlike'            => 'unlike',  
                        'POST view-counter'      => 'view-counter', 
                        'POST add-comment'      => 'add-comment',
                        'GET comment-list'      => 'comment-list', 
                        'POST share'              => 'share',  
                        'POST competition-image'  => 'competition-image',  
                        'POST report-post'  => 'report-post', 
                        'POST upload-gallary'  => 'upload-gallary', 
                        'GET promotion-ad-view'     => 'promotion-ad-view',
                        'GET hash-counter-list'     => 'hash-counter-list',
                        'GET my-stats'  => 'my-stats',
                        'GET insight'  => 'insight',
                        'GET post-promotion-ad'     => 'post-promotion-ad',
                        'GET trending-hashtag'      => 'trending-hashtag',
                        'GET post-video-list'       => 'post-video-list',
                        'GET post-like-user-list'  => 'post-like-user-list',
                        'GET my-post-promotion-ad'     => 'my-post-promotion-ad',

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/collection',
                    'extraPatterns' => [
                        'POST add-post'               => 'add-post',
                        'POST remove-post'               => 'remove-post',
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/highlight',
                    'extraPatterns' => [
                        'POST add-story'               => 'add-story',
                        'POST remove-story'               => 'remove-story',
                        'POST report-highlight'               => 'report-highlight',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/notification',
                    'extraPatterns' => [
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/competition',
                    'extraPatterns' => [
                        'POST join'  => 'join',
                        'GET my-competition'  => 'my-competition',  
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/package',
                    'extraPatterns' => [],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/setting',
                    'extraPatterns' => [],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/support-request',
                    'extraPatterns' => [
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/file-upload',
                    'extraPatterns' => [
                        'POST upload-file'       => 'upload-file',
                        'POST upload-file-receive'       => 'upload-file-receive',
                        'POST upload-file-binary'       => 'upload-file-binary',
                        
                    ],
                ],
                
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/story',
                    'extraPatterns' => [
                        'GET my-story' => 'my-story',
                        'GET my-active-story' => 'my-active-story',
                        'POST view-counter' => 'view-counter',
                        'GET story-view-user' => 'story-view-user',
                        // 'POST create-story' => 'create-story',
                        'POST report-story' => 'report-story',
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/blocked-user',
                    'extraPatterns' => [
                        'POST un-blocked' => 'un-blocked'
                        
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/chat',
                    'extraPatterns' => [
                        'POST create-room'           => 'create-room',
                        'GET room'                   => 'room',
                        'GET open-room'              => 'open-room',
                        'GET room-detail'            => 'room-detail',
                        'GET delete-room'            => 'delete-room',
                        'POST upload-media-file'     => 'upload-media-file',
                        'GET call-history'           => 'call-history',
                        'POST update-room'           => 'update-room',
                        'GET live-user'              => 'live-user',
                        'GET online-user'             => 'online-user',
                        'GET chat-message'           => 'chat-message',
                        'POST delete-room-chat'           => 'delete-room-chat',
                        'GET live-streaming-user'           => 'live-streaming-user',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/club',
                    'extraPatterns' => [
                        'GET category'                => 'category',
                        'POST join'                   => 'join',
                        'POST left'                   => 'left',
                        'POST remove'                 => 'remove',
                        'GET club-joined-user'        => 'club-joined-user',
                        'POST invite'                 => 'invite',
                        'GET my-invitation'        => 'my-invitation',
                        'POST invitation-reply'     => 'invitation-reply',
                        'POST join-request'     => 'join-request',
                        'GET join-request-list'        => 'join-request-list',
                        'POST join-request-reply'     => 'join-request-reply',
                        'GET top-club'     => 'top-club',
                        
                        
                        
                        
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/live-tv',
                    'extraPatterns' => [
                        'POST subscribe' => 'subscribe',
                        'POST stop-viewing' => 'stop-viewing',
                        'GET my-subscribed-list' => 'my-subscribed-list',
                        'POST add-favorite' => 'add-favorite',
                        'POST remove-favorite' => 'remove-favorite',
                        'GET my-favorite-list' => 'my-favorite-list',
                        'GET tv-shows' => 'tv-shows',
                        'GET tv-show-episodes' => 'tv-show-episodes',
                        'GET tv-channel-details'     => 'tv-channel-details'
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/tv-show',
                    'extraPatterns' => [                        
                        'GET tv-show-episodes' => 'tv-show-episodes',
                        'GET tv-show-details'  => 'tv-show-details'                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/tv-banner',
                    'extraPatterns' => [                       
                        // 'GET tv-shows' => 'tv-shows',
                                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/podcast',
                    'extraPatterns' => [
                        'POST subscribe' => 'subscribe',
                        'POST stop-viewing' => 'stop-viewing',
                        'GET my-subscribed-list' => 'my-subscribed-list',
                        'POST add-favorite' => 'add-favorite',
                        'POST remove-favorite' => 'remove-favorite',
                        'GET my-favorite-list' => 'my-favorite-list',
                        'GET podcast-shows' => 'podcast-shows',
                        'GET podcast-show-episodes' => 'podcast-show-episodes',
                        'GET podcast-host-details' => 'podcast-host-details',
                                               
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/podcast-show',
                    'extraPatterns' => [                        
                        'GET podcast-show-episodes' => 'podcast-show-episodes',
                        'GET podcast-show-details'   => 'podcast-show-details'                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/podcast-banner',
                    'extraPatterns' => [                       
                        // 'GET tv-shows' => 'tv-shows',
                                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/gift',
                    'extraPatterns' => [
                        'POST send-gift' => 'send-gift',
                        'GET recieved-gift' => 'recieved-gift',
                        'GET popular' => 'popular',
                        'GET top-gift-reciever' => 'top-gift-reciever',
                        'POST send-timeline-gift' => 'send-timeline-gift',
                        'GET timeline-gift' => 'timeline-gift',
                        'GET timeline-gift-recieved' => 'timeline-gift-recieved',
                        'GET live-call-gift-recieved' => 'live-call-gift-recieved',
                        'GET live-call-gift-top-contributer' => 'live-call-gift-top-contributer'
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user-live-history',
                    'extraPatterns' => [
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user-verification',
                    'extraPatterns' => [
                        'POST cancel' => 'cancel',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/event',
                    'extraPatterns' => [
                        'GET coupon' => 'coupon',
                        'POST buy-ticket' => 'buy-ticket',
                        'POST gift-ticket' => 'gift-ticket',
                        'GET my-booked-event' => 'my-booked-event',
                        'POST cancel-ticket-booking' => 'cancel-ticket-booking',
                        'POST create-event' => 'create-event',
                        'POST create-ticket'=> 'create-ticket',
                        'POST update-ticket' => 'update-ticket',                        
                        'GET list' => 'list',                        
                        'GET ticket-list' => 'ticket-list',                                     
                        'POST create-coupon' => 'create-coupon',
                        'POST update-coupon' => 'update-coupon',
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/poll',
                    'extraPatterns' => [
                        'GET poll-question' => 'poll-question', 
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/poll-question',
                    'extraPatterns' => [
                        // 'GET poll-question' => 'poll-question', 
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/poll-option',
                    'extraPatterns' => [
                        // 'GET poll-question' => 'poll-question', 
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/poll-question-answer',
                    'extraPatterns' => [
                        'POST add-answer' => 'add-answer', 
                        
                    ],
                ],


                
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/campaign',
                    'extraPatterns' => [
                        'POST add-comment'      => 'add-comment',
                        'GET comment-list'      => 'comment-list', 
                        'POST add-favorite' => 'add-favorite',
                        'POST remove-favorite' => 'remove-favorite',
                        'GET my-favorite-list' => 'my-favorite-list',
                        'POST payment' => 'payment',
                        'GET donors-list'      => 'donors-list',
                        'POST delete-comment'      => 'delete-comment',
                        
                    ],
                ],


                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/organization',
                    'extraPatterns' => [
                        'GET list' => 'list',
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/relation',
                    'extraPatterns' => [
                        'POST invite' => 'invite',
                        'GET my-invitation' => 'my-invitation',
                        'PUT update-invitation' => 'update-invitation',
                        'GET my-relation' => 'my-relation',
                        'GET user-relation' => 'user-relation'
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/interest',
                    'extraPatterns' => [ 
                        
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/profile-category-type',
                    'extraPatterns' => [
                      
                        
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/dating',
                    'extraPatterns' => [
                        'POST add-user-preference'      => 'add-user-preference',
                        'GET preference-profile'        => 'preference-profile',
                        'GET preference-profile-match'        => 'preference-profile-match',
                        'GET profile-matching'      => 'profile-matching',
                        'GET profile-like-lists'      => 'profile-like-lists',
                        'POST profile-action-like'      => 'profile-action-like',
                        'POST profile-action-skip'      => 'profile-action-skip',
                        'POST profile-action-remove'      => 'profile-action-remove',
                        'GET profile-like-by-other-users' => 'profile-like-by-other-users',
                        'GET subscription-package' => 'subscription-package',
                        'POST subscribe-package' => 'subscribe-package',
                        
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/language',
                    'extraPatterns' => [
                        
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/business',
                    'extraPatterns' => [
                        'GET lists'        => 'lists',
                        'GET my-favorite-list' => 'my-favorite-list',
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/coupon',
                    'extraPatterns' => [
                        'GET lists'        => 'lists',
                        'GET share'        => 'share',
                        'POST add-comment' => 'add-comment',
                        'GET comment-list'        => 'comment-list',
                        'POST add-favorite' => 'add-favorite',
                        'POST remove-favorite' => 'remove-favorite',
                        'GET my-favorite-list' => 'my-favorite-list',
                        'POST delete-comment' => 'delete-comment',
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/audience',
                    'extraPatterns' => [
                        
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/post-promotion',
                    'extraPatterns' => [
                        'POST update-status' => 'update-status',
                        'POST cancel' => 'cancel'
                         
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/rating',
                    'extraPatterns' => [
                        
                         
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/cron',
                    'extraPatterns' => [
                        'GET process-twice' => 'process-twice',
                        'GET post-promotion-complete' => 'post-promotion-complete',
                        'GET streamer-award' => 'streamer-award',
                        'GET ad-status' => 'ad-status',
                         
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/job',
                    'extraPatterns' => [
                        // 'GET poll-question' => 'poll-question', 
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/job-application',
                    'extraPatterns' => [
                        // 'GET poll-question' => 'poll-question', 
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/ad-favorite',
                    'extraPatterns' => [
                        'POST delete-list'       => 'delete-list',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/ad-package',
                    'extraPatterns' => [
                       
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/promotional-banner',
                    'extraPatterns' => [
                       
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/promotional-ad',
                    'extraPatterns' => [
                       
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/post-comment',
                    'extraPatterns' => [
                        'POST report-comment' => 'report-comment',
                         
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/reported-content',
                    'extraPatterns' => [
                         
                   ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/comment',
                    'extraPatterns' => [
                        'POST like' => 'like',
                        'POST unlike' => 'unlike'
                         
                   ],
                ],
               
            ],
        ],      
          /*  
        'response' => [
           
            'format'=>yii\web\Response::FORMAT_JSON,
           
            // ...
          
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    // ...
                ],
            ],
        ],



      
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                    
                    ],
                    [
                        'class' => 'yii\rest\UrlRule', 
                        'controller' => 'v1/photo',
                        'tokens' => [
                            '{id}' => '<id:\\w+>'
                        ]
                        
                    ]
            ],        
        ]*/
    ],
    'params' => $params,
];



