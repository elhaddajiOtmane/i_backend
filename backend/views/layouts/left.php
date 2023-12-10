<aside class="main-sidebar">

    <section class="sidebar">

      
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree',  'data-widget'=> 'tree'],
                'items' => [
                    
                    ['label' => 'Dashboard', 'icon' => 'ion fa-tachometer',  'aria-hidden'=>"true", 'url' => Yii::$app->homeUrl],
                    ['label' => 'Administrators', 'icon' => 'user',  'aria-hidden'=>"true", 'url' => ['/administrator']],
                    

                    [
                        'label' => 'Users',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Users', 'icon' => 'users',  'aria-hidden'=>"true", 'url' => ['/user']],
                            ['label' => 'User Verification', 'icon' => 'users',  'aria-hidden'=>"true", 'url' => ['/user-verification']],
                            ['label' => 'User Profile Category', 'icon' => 'users',  'aria-hidden'=>"true", 'url' => ['/user-profile-category']],
                           
                            
                        ],
                    ],
                    [
                        'label' => 'Post',
                        'icon' => 'fa-brands fa-wpforms',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Post', 'icon' => 'fa-brands fa-wpforms',  'aria-hidden'=>"true", 'url' => ['/post']],
                            ['label' => 'Reported Post', 'icon' => 'fa-brands fa-wpforms',  'aria-hidden'=>"true", 'url' => ['/post/reported-post']],
                           
                            
                        ],
                    ],
                    
                    [
                        'label' => 'Competition',
                        'icon' => 'fas fa-assistive-listening-systems',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Create Competition', 'icon' => 'fas fa-assistive-listening-systems',  'aria-hidden'=>"true", 'url' => ['/competition/create']],
                            ['label' => 'Competition', 'icon' => 'fas fa-list-ul',  'aria-hidden'=>"true", 'url' => ['/competition']],
                            
                            
                        ],
                    ],
                    [
                        'label' => 'Club',
                        'icon' => 'fas fa-bullhorn',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Club', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/club']],
                            ['label' => 'Club Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/club-category']],
                            
                        ],
                    ],
                   

                    ['label' => 'Support Request', 'icon' => 'fas fa-ticket',  'aria-hidden'=>"true", 'url' => ['/support-request']],
                    [
                        'label' => 'Payment',
                        'icon' => 'fas fa-money',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Payment Received', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/payment']], 
                            ['label' => 'Payment Request', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/withdrawal-payment']],
                            ['label' => 'Payout', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/withdrawal-payment','type'=>'completed']],        
                        ],
                    ],
                    /*['label' => 'Admin Wallet History', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['//payment/admin-wallet']],
                    [
                        'label' => 'Streamer Award Setting',
                        'icon' => 'fas fa-money',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Award Setting', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/stream-award-setting']], 
                            ['label' => 'Streamer Award', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/payment/streamer-award']],
                        ],
                    ],*/
                    ['label' => 'Packages', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/package']],

                    
                    

                    [
                        'label' => 'Tv Channel',
                        'icon' => 'fas fa-tv',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Tv Channel', 'icon' => 'fas fa-tv',  'aria-hidden'=>"true", 'url' => ['/live-tv']],
                            ['label' => 'Tv Channel Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/live-tv-category']],
                            [
                                'label' => 'Tv Show',
                                'icon' => 'fas fa-tv',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Tv Show', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/tv-show']],
                                    ['label' => 'Tv Show Categories', 'icon' => 'fas fa-tasks',  'aria-hidden'=>"true", 'url' => ['/category','type'=>3]],
                                    
                                ],
                               
                            ],
                            ['label' => 'Tv Banner', 'icon' => 'fas fa-file',  'aria-hidden'=>"true", 'url' => ['/tv-banner']],
                            ['label' => 'Tv Show Episode', 'icon' => 'fas fa-play',  'aria-hidden'=>"true", 'url' => ['/tv-show-episode']],
                        ],
                    ],

                    [
                        'label' => 'Podcast',
                        'icon' => 'fas fa-tv',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Host', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/podcast']],
                            // ['label' => 'Host Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/podcast-category']],
                            [
                                'label' => 'Podcast Show',
                                'icon' => 'fas fa-tv',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Podcast Show', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/podcast-show']],
                                    ['label' => 'Podcast Show Categories', 'icon' => 'fas fa-tasks',  'aria-hidden'=>"true", 'url' => ['/category','type'=>6]],
                                    
                                ],
                            ],
                            ['label' => 'Podcast Banner', 'icon' => 'fas fa-file',  'aria-hidden'=>"true", 'url' => ['/podcast-banner']],
                            ['label' => 'Podcast Episode', 'icon' => 'fas fa-play',  'aria-hidden'=>"true", 'url' => ['/podcast-show-episode']],
                        ],
                    ],

                    // [
                    //     'label' => 'Tv Show',
                    //     'icon' => 'fas fa-bullhorn',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Tv Show', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/tv-show']],
                    //         ['label' => 'Tv Show Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>3]],
                            
                    //     ],
                    // ],
                   
                    [
                        'label' => 'Gift',
                        'icon' => 'fab fa-yelp',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gift', 'icon' => 'fab fa-yelp',  'aria-hidden'=>"true", 'url' => ['/gift']],
                            ['label' => 'Gitf Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/gift-category']],
                            ['label' => 'Timeline Gift', 'icon' => 'fa fa-hourglass',  'aria-hidden'=>"true", 'url' => ['/gift-timeline']],
                            
                        ],
                    ],


                    [
                        'label' => 'FAQs',
                        'icon' => 'fas fa-question-circle',
                        'url' => '#',
                        'items' => [
                            ['label' => 'FAQ', 'icon' => 'fas fa-question-circle',  'aria-hidden'=>"true", 'url' => ['/faq']],
                            // ['label' => 'Gitf Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/gift-category']],
                            
                        ],
                    ],
                    [
                        'label' => 'Organization',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                         
                            ['label' => 'Orginazition', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/orginazition','type'=>5] ],
                            ['label' => 'Orginazition Type', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/orginazition-type']],
                            
                        ],
                    ],
                    
                    [
                        'label' => 'Event',
                        'icon' => 'fa fa-map-pin',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Event', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/event']],
                            ['label' => 'Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>1]],
                            [
                                'label' => 'Event Ticket',
                                'icon' => 'fas fa-question-circle',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Event Ticket', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/event-ticket']],
                                    ['label' => 'Add Ticket', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['//event-ticket/create']],
                                    
                                ],
                            ],
                            ['label' => 'Event Coupon', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/event-coupon']],
                            //['label' => 'Organisor', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/event-organisor']],
                            
                        ],
                    ],
                    

                    [
                        'label' => 'Fund Raising',
                        'icon' => 'fas fa-money',
                        'url' => '#',
                        'items' => [
                         
                            ['label' => 'Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>5] ],
                            ['label' => 'Campaign', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/campaign']],
                            
                        ],
                    ],


                    [
                        'label' => 'Reel',
                        'icon' => 'fas fa-play-circle',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Audio Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>4]],
                            ['label' => 'Audio', 'icon' => 'fas fa-volume-up',  'aria-hidden'=>"true", 'url' => ['/audio']],
                            ['label' => 'Reels', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/audio/post-reels']],
                            
                        ],
                    ],
                    
                    [
                        'label' => 'Polls',
                        'icon' => 'fab fa-gg',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Poll', 'icon' => 'fab fa-gg',  'aria-hidden'=>"true", 'url' => ['/poll']],
                            ['label' => 'Poll Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>7]],
                           
                           
                        ],
                    ],
                    [
                        'label' => 'Broadcast Notification',
                        'icon' => 'fas fa-bullhorn',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Send broadcast notification', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/broadcast-notification/create']],
                            ['label' => 'Broadcast Notification list', 'icon' => 'fas fa-bullhorn',  'aria-hidden'=>"true", 'url' => ['/broadcast-notification']],
                            
                            
                        ],
                    ],
                   

                    [
                        'label' => 'Coupon',
                        'icon' => 'fa-thin fa-tag',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Business Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>8]],
                            ['label' => 'Business', 'icon' => 'fa-solid fa-briefcase',  'aria-hidden'=>"true", 'url' => ['/business']],                            
                            ['label' => 'coupon', 'icon' => 'fa-thin fa-tag',  'aria-hidden'=>"true", 'url' => ['/coupon']]
                           
                        ],
                    ],
                   
                    [
                        'label' => 'Dating',
                        'icon' => 'fa-solid fa-heart',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Interest', 'icon' => 'fas fa-user',  'aria-hidden'=>"true", 'url' => ['/interest']],
                            ['label' => 'Subscription Package', 'icon' => 'fas fa-money',  'aria-hidden'=>"true", 'url' => ['/dating-subscription-package']],
                        ],
                    ],
                     /*
                    [
                        'label' => 'Vehicle',
                        'icon' => 'fa-solid fa-car',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Vehicle', 'icon' => 'fa-solid fa-car',  'aria-hidden'=>"true", 'url' => ['/vehicle']],
                          
                        ],
                    ],
                    [
                        'label' => 'Driver Document',
                        'icon' => 'fa-solid fa-file',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Driver Document', 'icon' => 'fa-solid fa-file',  'aria-hidden'=>"true", 'url' => ['/driver-document']],
                          
                        ],
                    ],*/
                    [
                        'label' => 'Promotion Details',
                        'icon' => 'fa-solid fa-money',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Running Promotion', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/post-promotion']],
                            ['label' => 'Completed Promotion', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/post-promotion/complete-promotion']],
                           
                          
                        ],
                    ],
                    [
                        'label' => 'Stories',
                        'icon' => 'fa-solid fa-money',
                        'url' => '#',
                        'items' => [
                           
                            ['label' => 'Active Story', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/story','StorySearch[filter_id]' => 1]],
                            ['label' => 'All Story', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/story']],
                           
                          
                        ],
                    ],


                    [
                        'label' => 'Live History',
                        'icon' => 'fa-solid fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Live History', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/user-live-history']],
                          
                        ],
                    ],
                    [
                        'label' => 'Jobs',
                        'icon' => 'fa-solid fa-shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Job Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>10]],
                            ['label' => 'Job', 'icon' => 'fa-solid fa-shopping-bag',  'aria-hidden'=>"true", 'url' => ['/job']],
                            ['label' => 'Job Applications', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/job-application']],
                          
                        ],
                    ],
                    
                    [
                        'label' => 'Ads',
                        'icon' => 'fas fa-tv',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Membership',
                                'icon' => 'fa-solid fas fa-money',
                                'url' => '#',
                                'items' => [
                                    // ['label' => 'Packages', 'icon' => 'fa-solid fas fa-money',  'aria-hidden'=>"true", 'url' => ['/ad-package']],
                                    ['label' => 'Promotional Banner', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/promotional-banner']],
                                  
                                ],
                            ],
                            [
                                'label' => 'Category',
                                'icon' => 'fa-solid fa-list-alt',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Ad Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/category','type'=>9]],
                                    ['label' => 'Ad Sub Categories', 'icon' => 'list-alt',  'aria-hidden'=>"true", 'url' => ['/categorysub']],
                                  
                                ],
                            ],
                            [
                                'label' => 'Ad',
                                'icon' => 'fas fa-tv',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Active Ads', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/ad','type'=>'active']],
                            ['label' => 'Pending Ads', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/ad','type'=>'pending']],
                            ['label' => 'All Ads', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/ad','type'=>'all']],
                            ['label' => 'Expired Ads', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/ad','type'=>'expire']],
                                  
                                ],
                            ],                     
                            
                            ['label' => 'Promotional Ads', 'icon' => 'picture-o',  'aria-hidden'=>"true", 'url' => ['/promotional-ad']],
                          
                        ],
                    ],
                    [
                        'label' => 'Report',
                        'icon' => 'fa-brands fa-wpforms',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Reported User', 'icon' => 'ion fa-bell',  'aria-hidden'=>"true", 'url' => ['/user/reported-user']],
                            ['label' => 'Reported Post', 'icon' => 'fa-brands fa-wpforms',  'aria-hidden'=>"true", 'url' => ['/post/reported-post']],
                            ['label' => 'Reported Post Comment', 'icon' => 'fa-brands fa-wpforms',  'aria-hidden'=>"true", 'url' => ['/post-comment/reported-comment']],
                            ['label' => 'Reported Story', 'icon' => 'fa-solid fa-list',  'aria-hidden'=>"true", 'url' => ['/story/reported-story']],
                            ['label' => 'Reported Ads', 'icon' => 'ion fa-bell',  'aria-hidden'=>"true", 'url' => ['/ad/reported-ads']],
                            ['label' => 'Reported Highlight', 'icon' => 'fas fa-heart',  'aria-hidden'=>"true", 'url' => ['/highlight/reported-highlight']],
                           
                            
                        ],
                    ],
                    
                    [
                        'label' => 'Setting',
                        'icon' => 'ion fa-wrench',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Contact Information', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting']],
                            ['label' => 'General Setting', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/general-information']],
                            ['label' => 'Payment Setting', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/payment']],
                            ['label' => 'Social Links', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/social-links']],
                            ['label' => 'App Settings', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/app-setting']],
                            ['label' => 'Feature Availability', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/feature']],
                            ['label' => 'App Theme Setting', 'icon' => 'ion fa-wrench',  'aria-hidden'=>"true", 'url' => ['/setting/app-theme-setting']],
                            
                            
                        ],
                    ],
                    

                ],
            ]
        ) ?>

    </section>

</aside>
