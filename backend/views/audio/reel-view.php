<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Countryy */

$this->title = 'View Reels';
$this->params['breadcrumbs'][] = ['label' => 'Audio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-body">
            <div class="reel-main">
            <?php 

                if($postResult->postReelGallary->media_type ==1){
                    echo Html::img($postResult->postReelGallary->filenameUrl, ['alt' => 'No Image','width'=>"50%" ,'height'=>"50%" ]);
                
                    echo Html::tag('audio', '', [
                        'id' => 'audioPlayer',
                        'src' => @$model->audioUrl,
                        'controls' => true,
                        'style' => 'position: absolute; top: 0; left: 0;',
                    ]);
                }elseif($postResult->postReelGallary->media_type ==2){
             ?>
           
            <video id="videoPlayer" height="500px" src="<?= @$postResult->postReelGallary->filenameUrl ?>" ></video>
            <audio id="audioPlayer" src="<?= @$model->audioUrl ?>" controls style="display:none;"></audio>
            <button id="playButton"><i class="fa fa-play-circle" aria-hidden="true"></i></button>
          
             <?php
                }
                ?>
           
           </div>
            <style>
                .reel-main{
                    position: relative;
                }
                button#playButton {
                position: absolute;
                top: 50%;
                left: 6%;
                border-radius: 50%;
                background: #fffcfc73;
                width: 50px;
                height: 50px;
                border: 0;
                }
                button#playButton i.fa {
                    font-size: 40px;
                }

            </style>
              
            </div>


        </div>

    </div>
</div>
<?php
$js=<<< JS
    $(document).ready(function(){
    var video = document.getElementById("videoPlayer");
    var audio = document.getElementById("audioPlayer");
    var audioStartTime = "$postResult->audio_start_time"; // Set the desired start time in seconds
    var audioStopTime = "$postResult->audio_end_time"; // Set the desired stop time in seconds

    // Play or stop video and audio when the play button is clicked
    var playButton = document.getElementById("playButton");
    playButton.addEventListener("click", function() {
      if (video.paused && audio.paused) {
        video.currentTime = 0;
        if (audioStartTime !== "" && audioStopTime !== "") {
          audio.currentTime = audioStartTime;
          setTimeout(function() {
            video.pause();
            audio.pause();
          }, (audioStopTime - audioStartTime) * 1000);
        }
        video.play();
        audio.play();
        playButton.innerHTML = '<i class="fa fa-pause-circle" aria-hidden="true"></i>'; 
      } else {
        video.pause();
        audio.pause();
        playButton.innerHTML = '<i class="fa fa-play-circle" aria-hidden="true"></i>'; // Change button text back to "Play"
      }
    });
  });    

JS;
$this->registerJs($js,\yii\web\view::POS_READY);
?>