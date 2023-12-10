<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Countryy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countryy-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>General Setting</h4>
        </div>
        <div class="panel-body">
            
            <?php  echo  $form->field($model, 'release_version')->textInput(['maxlength' => true]) ?>
            <?php  echo  $form->field($model, 'website_name')->textInput(['maxlength' => true]) ?>
            <?php  echo  $form->field($model, 'website_url')->textInput(['maxlength' => true]) ?>
            <?php  echo  $form->field($model, 'moments_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ads_auto_approve')->dropDownList($model->getAutoAdsDropDownData()); ?>
        </div>
    </div>

   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS

JS;
    $this->registerJs($js, \yii\web\view::POS_READY);
    ?>