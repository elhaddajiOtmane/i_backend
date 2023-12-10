<?php

namespace backend\controllers;

use Yii;
//use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Event;
use common\models\EventTicket;
use common\models\EventTicketBooking;
use backend\models\EventTicketBookingSearch;

/**
 * 
 */
class EventTicketBookingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all  models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventTicketBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $modelEvent = new Event();
        

        $resultEvent = $modelEvent->find()->select(['id','name'])->andWhere(['<>', 'status', Event::STATUS_DELETED])->all();
       
        $eventData = ArrayHelper::map($resultEvent,'id','name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'eventData' =>$eventData
        ]);
    }

    /**
     * Displays a single Countryy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        
        return $this->render('view', [
            'model' =>   $model
        ]);
    }

    
    /**
     * Finds the Countryy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countryy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventTicketBooking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}