<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Countryy */

$this->title = 'Make ad featured :'.$model->title ;
//$this->params['breadcrumbs'][] = ['label' => 'Countryys', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= $this->render('_form-make-featured', [
                    'model' => $model,
                    'adType'=>$adType
                    
                    
                ]) ?>
            </div>
        </div>
    </div>
</div>