<?php

namespace app\controllers;

use Yii;
use app\models\Receipt;
use app\Models\SearchReceipt;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

/**
 * ReceiptController implements the CRUD actions for Receipt model.
 */
class ReceiptController extends Controller {

    /**
     * {@inheritdoc}
     */
    public $KEY_RUN = 'RE';
    public $FIELD_NAME = 'id';
    public $TABLE_NAME = 'receipt';
    public $Month, $Year, $CODE, $LastID, $Key, $last_id = "";  // เก็บค่าเดือน เช่น 04  date("m")
    public $last_3_digit, $new_3_digit;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'payment', 'print', 'reject'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'payment', 'print', 'reject'],
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
     * Lists all Receipt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\models\SearchReceipt();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receipt model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPayment($id, $leasing) {
        $model = new Receipt();
        //$model->scenario = 'payment';
        $room = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $leasing])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $leasing])->one();
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2])->all();
        } else {
            $dataCustomer2 = NULL;
        }
        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer])->all();

        $invoice = \app\models\Invoice::findAll(['id' => $id]);
        $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
        //die(print_r($invoice));
        foreach ($invoice as $data) {
            $model->invoice_id = $data['id'];
            $model->leasing_id = $data['leasing_id'];
            $model->rental = $data['rental'];
            if ($data['deposit'] == NULL) {
                $model->deposit = 0;
            } else {
                $model->deposit = $data['deposit'];
            }

            $model->water_price = $data['water_price'];
            $model->electric_price = $data['electric_price'];
            $model->additional_1 = $data['additional_1'];
            $model->additional_1_price = $data['additional_1_price'];
            $model->additional_2 = $data['additional_2'];
            $model->additional_2_price = $data['additional_2_price'];
            $model->additional_3 = $data['additional_3'];
            $model->additional_3_price = $data['additional_3_price'];
            $model->additional_4 = $data['additional_4'];
            $model->additional_4_price = $data['additional_4_price'];
            $model->additional_5 = $data['additional_5'];
            $model->additional_5_price = $data['additional_5_price'];
            $model->refun_1 = $data['refun_1'];
            $model->refun_1_price = $data['refun_1_price'];
            $model->refun_2 = $data['refun_2'];
            $model->refun_2_price = $data['refun_2_price'];
            $model->total = $data['total'];
            $model->comment = $data['comment'];
            $model->invoice_id = $id;
            $appointment = $data['appointment'];
            $invoice_date = $data['invoice_date'];
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
            //return $this->redirect(['view', 'id' => $model->id]);
            $transection = Yii::$app->db->beginTransaction();
            $status = \app\models\Invoice::findOne($model->invoice_id);                        //$status->scenario = 'changestatus';
            //die(print_r($status));
            $status->status = 'ชำระแล้ว';
            if ($model->water_price == NULL) {
                $model->water_price = 0;
            }
            if ($model->electric_price == NULL) {
                $model->electric_price = 0;
            }
            //die(print_r($status));
            try {
                if ($model->save(false) && $status->save(false)) {
                    // update สถานะ ใบแจ้งหนี้
                    //$invoice_status = new \app\models\Invoice();
                    $transection->commit();
                    return $this->redirect(['viewreceipt', 'id' => $model->id, 'leasing' => $model->leasing_id]);
                } else {
                    $transection->rollBack();
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                    return $this->redirect(['invoice/index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด' . $ex);
                return $this->redirect(['index']);
            }
        }

        return $this->render('payment', [
                    'model' => $model,
                    'room' => $room,
                    'customer' => $dataCustomer,
                    'customer2' => $dataCustomer2,
                    'invoice' => $invoice,
                    'appointment' => $appointment,
                    'invoice_date' => $invoice_date,
        ]);
    }

    public function actionViewreceipt($id, $leasing) {

        $model = $this->findModel($id);
        $room = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $leasing])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $leasing])->one();
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2])->all();
        } else {
            $dataCustomer2 = NULL;
        }
        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer])->all();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
                        'room' => $room,
                        'customer' => $dataCustomer,
                        'customer2' => $dataCustomer2,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
                        'room' => $room,
                        'customer' => $dataCustomer,
                        'customer2' => $dataCustomer2,
            ]);
        }
    }

    public function actionPrint($id, $leasing) {

        $model = $this->findModel($id);
        $room = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $leasing])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $leasing])->one();
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2->customers_id])->all();
        } else {
            $dataCustomer2 = NULL;
        }
        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer])->all();

        $content = $this->renderPartial('print', [
            'model' => $model,
            'room' => $room,
            'customer' => $dataCustomer,
            'customer2' => $dataCustomer2,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, //
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            //'format' => [210, 148.5],
            'marginLeft' => 10,
            'marginRight' => 10,
            'marginTop' => 10,
            'marginBottom' => 5,
            'marginHeader' => 5,
            'marginFooter' => 5,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile' => '@web/css/pdf.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:10px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'ใบเสร็จรับเงิน'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
            ]
        ]);

        $pdf->getApi()->SetJS('this.print();');

        return $pdf->render();
    }

    /**
     * Updates an existing Receipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Receipt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionReject($id, $invid) {

        $transection = Yii::$app->db->beginTransaction();
        $invoice_status = new \app\models\Invoice();
        $status = $invoice_status::findOne($invid);
        $status->status = 'รอการชำระ';
        //die(print_r($status));
        if ($status->save(false)) {

            $this->findModel($id)->delete();

            $transection->commit();
            Yii::$app->session->setFlash('success', 'ยกเลิกใบเสร็จเรียบร้อยแล้ว');
            return $this->redirect(['index']);
        } else {
            $transection->rollBack();
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด ไม่สามารถยกเลิกรายการได้');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Receipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Receipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function RunningCodes($field, $table, $key) {

        $this->Month = date("m");
        $this->Year = substr((date("Y")), 2);

        $this->CODE = $key . $this->Year . $this->Month;
        $run = $this->findCode($field, $table, $this->CODE);

        if (isset($run['id'])) {

            $this->last_id = $run['id'];
            //echo $last_id."<br>";
            $this->last_3_digit = substr($this->last_id, -3, 3); // ตัดเอาเฉพาะ 4 หลักสุดท้าย
            //echo $last_4_digit."<br>";

            $this->last_3_digit = $this->last_3_digit + 1;
            //echo $last_4_digit."<br>";
            while (strlen($this->last_3_digit) < 3) {
                $this->last_3_digit = "0" . $this->last_3_digit;
            }
            $this->CODE = $this->CODE . $this->last_3_digit;
            return $this->CODE;
            //$ObjQry=mysql_query("INSERT INTO create_id(row,id) VALUES('','$CODE')");
        } else {
            $this->CODE = $this->CODE . "001";
            return $this->CODE;
        }
    }

    public function findCode($field, $table, $code) {
        $sql = "SELECT MAX($field) as id FROM $table WHERE $field LIKE '$code%'";

        //$command = Yii::$app()->createCommand($sql);
        $row = Yii::$app->db->createCommand($sql)->queryOne();
        return $row;
    }

}
