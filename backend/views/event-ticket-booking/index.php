<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CountryySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Ticket Booking';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12"><div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right"><?= Html::a('Create', ['create'], ['class' => 'btn btn-success pull-right']) ?></div>
                <div style="clear:both"></div>


                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                      
                        [
                            'attribute'  => 'event_id',
                            'value' => function($model){
                                return @$model->event->name;
                                
                                
                            },
                            'filter'=>Html::activeDropDownList($searchModel, 'event_id', $eventData,['class'=>'form-control','prompt' => 'All']),
                            'format'=>'raw'
                        ],
                        [
                            'attribute'  => 'user_id',
                            'value' => function($model){
                                
                                return Html::a(@$model->user->name, ['/user/view', 'id' => $model->user_id]);
                            },
                          
                            'format'=>'raw'
                        ],
                        
                        'created_at:datetime',
                        [
                            'attribute'  => 'event_ticket_id',
                            'value'  => function ($data) {
                                return $data->ticket_qty.' x '.$data->ticket->ticket_type;
                            },
                            'format'=>'raw'
                        ],
                       
                        
                        
                        [
                            'attribute'  => 'status',
                            'value'  => function ($data) {
                                return $data->getStatusButton();
                            },
                            'format'=>'raw'
                        ],
                       
                         [
							'class' => 'yii\grid\ActionColumn',
							 'header' => 'Action',
                             'template' => '{view}',
                         ],
                    
                    ],
                    'tableOptions' => [
                        'id' => 'theDatatable',
                        'class' => 'table table-striped table-bordered table-hover',
                    ],
                ]); ?>
            </div>


        </div>
        <!-- /.box -->



        <!-- /.col -->
    </div>
</div>