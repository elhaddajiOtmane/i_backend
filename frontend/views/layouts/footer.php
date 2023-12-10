<?php 
use yii\helpers\Url;
?>
<footer class="footer_all">
    <div class="footer">
        <div class="container spacer b-t">

            <div class="footer-top d-flex justify-content-between">
               
                <!--<div class="footer-subscribe">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"> <span class="input-group-text"><i
                                    class="fa fa-envelope-o"></i></span> </div>
                        <input type="text" class="form-control text-truncate" placeholder="Subscribe to Our News Offers"
                            aria-label="Amount (to the nearest dollar)">
                    </div>
                </div>-->
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 m-b-30">
          <h3 class="mb-3"> <img class="img-fluid" src="http://fwdtechnology.co/classified_mark/images/logo-green.png" alt="footer-logo"> </h3>
          <p>About us text here.. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
</p>
        </div>
        
        <div class="col-lg-3 col-md-3 m-b-30">
          <h3 class="mb-3"><?=Yii::t('app','Quik Links')?> </h3>
          <ul class="p-0">
            
            <li><a href="<?= Yii::$app->homeUrl?>"><?=Yii::t('app','Home')?></a></li>
            <li><a href="<?=  Url::to(['/site/about-us']);?>"><?=Yii::t('app','About Us')?></a></li>
            <li><a href="<?=  Url::to(['/ad']);?>"><?=Yii::t('app','Ads')?></a></li>
           <!--<li><a href="#">Help</a></li>
              <li><a href="#">Help & Support</a></li>
            <li><a href="#">Advertise With Us</a></li>
             <li><a href="#">FAQ</a></li>-->
          </ul>
        </div>


                <div class="col-lg-3 col-md-3 m-b-30">
                    
                    <h3 class="mb-3 mt-3"><?=Yii::t('app','Follow Us')?></h3>
                    <ul class="list-unstyled d-flex p-0 soical-icon">
                        <li class="mr-2"><a href="#"><i class="fa fa-facebook-f"></i> </a></li>
                        <li class="mr-2"><a href="#"><i class="fa fa-twitter"></i> </a></li>
                        <li class="mr-2"><a href="#"><i class="fa fa-google-plus"></i> </a></li>
                        <li class="active"><a href="#"><i class="fa fa-linkedin"></i> </a></li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
    <div class="bottom-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mt-3 mb-3 copyright">&copy;Copyright 2000-2022 example.com Limited. All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<div class="top_awro pull-right" id="back-to-top" data-original-title="" title=""><i class="fa fa-chevron-up"
        aria-hidden="true"></i> </div>