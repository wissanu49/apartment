<?php

namespace app\controllers;

use Yii;
use app\models\Energies;
use app\models\EnergiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EnergiesController implements the CRUD actions for Energies model.
 */
class EnergiesController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'add', 'histories', 'bulk'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'add', 'histories', 'bulk'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Energies models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\models\EnergiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Energies model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Energies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdd($room) {
        $model = new Energies();
        $model->scenario = 'add_data';
        $model->rooms_id = $room;
        $model->users_id = Yii::$app->user->identity->id;

        $dataProvider = Energies::find()->where(['rooms_id' => $room])->orderBy('peroid DESC')->limit(5)->all();
        if ($model->load(Yii::$app->request->post())) {
            $transection = \Yii::$app->db->beginTransaction();
            try {
                //$model->users_id = Yii::$app->user->identity->id;
                $model->record_date = date('Y-m-d H:i:s');
                //die(var_dump($model));
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                    $transection->commit();
                    return $this->redirect(['rooms/index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', $ex);
            }
        }

        return $this->renderAjax('create', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBulk($building) {
        $model = new Energies();

        //$model->rooms_id = $room;
        $model->users_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
            $transection = \Yii::$app->db->beginTransaction();
            try {
                $flag = 0;
                //$model->save(); //บันทึกใบ Order

                $items = Yii::$app->request->post();

                //die(print_r($items['Energies']['items']));

                foreach ($items['Energies']['items'] as $key => $val) { //นำรายการที่เลือกมา loop บันทึก
                    $energies = new Energies();
                    //$energies->scenario = 'add_data';
                    //$id = Energies::find()->select('MAX(id) as id')->one();
                    /*
                      if(empty($val['id'])){
                      $order_detail = new Energies();
                      }else{
                      $order_detail = OrderDetail::findOne($val['id']);
                      }
                     * 
                     */
                    //$model->id =  $model->id + ($id->id +1 );
                    if (($val['peroid'] != "") && ($val['water_unit'] != "") && ($val['electric_unit'] != "") && ($val['rooms_id'] != "")) {
                        $energies->peroid = $val['peroid'];
                        $energies->water_unit = $val['water_unit'];
                        $energies->electric_unit = $val['electric_unit'];
                        $energies->rooms_id = $val['rooms_id'];
                        $energies->users_id = Yii::$app->user->identity->id;
                        $energies->record_date = date('Y-m-d H:i:s');
                        $save = $energies->save();
                        if (!$save) {
                            $flag += 1;
                        }
                    }
                }

                if ($flag == 0) {
                    $transection->commit();
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['building/index']);
                    //return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $transection->rollBack();
                    Yii::$app->session->setFlash('error', 'มีข้อผิดพลาดในการบันทึก');
                    return $this->redirect(['building/index']);
                }
            } catch (Exception $ex) {
                $transection->rollBack();
                Yii::$app->session->setFlash('error', 'มีข้อผิดพลาดในการบันทึก');
                return $this->redirect(['building/index']);
            }
        }

        return $this->renderAjax('bulk', [
                    'model' => $model,
                    'building' => $building,
        ]);
    }

    public function actionHistories($room) {

        $dataProvider = Energies::find()->where(['rooms_id' => $room])->orderBy('peroid DESC')->limit(12)->all();
        $rooms = \app\models\Rooms::find()->select('name')->where(['id' => $room])->one();
        //die(print_r($dataProvider));
        return $this->renderAjax('histories', [
                    'dataProvider' => $dataProvider,
                    'roomname' => $rooms->name,
        ]);

        //return $this->renderAjax('histories');
    }

    /**
     * Updates an existing Energies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['rooms/index']);
            }

            //return $this->goBack();
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Energies model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Energies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Energies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Energies::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
