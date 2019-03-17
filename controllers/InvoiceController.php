<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\Models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use kartik\mpdf\Pdf;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller {

    /**
     * {@inheritdoc}
     */
    public $KEY_RUN = 'IN';
    public $FIELD_NAME = 'id';
    public $TABLE_NAME = 'invoice';
    public $Month, $Year, $CODE, $LastID, $Key, $last_id = "";  // เก็บค่าเดือน เช่น 04  date("m")
    public $last_3_digit, $new_3_digit;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create', 'deposit', 'invoice', 'checkout', 'print'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'create', 'deposit', 'invoice', 'checkout', 'print'],
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\models\SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($room) {
        $model = new Invoice();
        $model->scenario = 'create';

        $leasing = \app\models\Leasing::find()->select('id')->where(['rooms_id' => $room, 'status' => 'IN'])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing->id])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $leasing->id])->one();
        
        // เก็บข้อมูล roommate
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2->customers_id])->all();
        } else {
            $dataCustomer2 = NULL;
        }

        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer->customers_id])->all();
        $rental = \app\models\Rooms::getPrice($room);
        $building = \app\models\Building::getBuildingId($room);
        
        $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
        $model->leasing_id = $leasing->id;
        $model->rental = $rental;

        // เก็บข้อมูลรายการ ค่าน้ำ ค่าไฟ
        //$config = \app\models\Company::find()->all();
        $config = \app\models\Company::companyProfile($building);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
            $model->invoice_date = date('Y-m-d H:i:s');

            try {
                $transection = \Yii::$app->db->beginTransaction();
                //die(print_r($model));
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                    $transection->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด. กรุณาลองใหม่อีกครั้ง');
                    $transection->rollBack();
                    //return $this->redirect(['index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด.' . $ex);
                //return $this->redirect(['create']);
            }
        }

        return $this->render('_create', [
                    'model' => $model,
                    'room' => $room,
                    'customer' => $dataCustomer,
                    'customer2' => $dataCustomer2,
                    'config' => $config,
        ]);
    }

    public function actionCheckout($room, $leasing) {
        $model = new Invoice();
        //$model->scenario = 'checkout';
        //$leasing = \app\models\Leasing::find()->select('id')->where(['rooms_id' => $room, 'status'=>'IN'])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing])->one();

        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer->customers_id])->all();
        $rental = \app\models\Rooms::getPrice($room);
        $deposit = \app\models\Rooms::getDeposit($room);
        $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
        $model->leasing_id = $leasing;
        $model->rental = $rental;

        $config = \app\models\Company::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
            $model->invoice_date = date('Y-m-d H:i:s');

            try {
                $transection = \Yii::$app->db->beginTransaction();
                //die(print_r($model));
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                    $transection->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด. กรุณาลองใหม่อีกครั้ง');
                    $transection->rollBack();
                    //return $this->redirect(['index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด.' . $ex);
                return $this->redirect(['rooms/index']);
            }
        }

        return $this->render('checkout', [
                    'model' => $model,
                    'room' => $room,
                    'customer' => $dataCustomer,
                    'config' => $config,
                    'deposit' => $deposit,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {

        $model = $this->findModel($id);

        $query = new Query;
        $query->select([
                    'invoice.*',
                    'leasing.id as leasing', 'leasing.roommate_id',
                    'rooms.name as room',
                    'customers.id as customer_id', 'customers.fullname', 'customers.address', 'customers.phone',
                ])
                ->from('invoice')
                ->where(['invoice.id' => $id])
                ->join('LEFT OUTER JOIN', 'leasing', 'leasing.id = invoice.leasing_id')
                ->join('INNER JOIN', 'rooms', 'rooms.id = leasing.rooms_id')
                ->join('INNER JOIN', 'customers', 'customers.id = leasing.customers_id');

        $command = $query->createCommand();
        $data = $command->queryAll();
        //die(print_r($data));
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('viewInvoice', [
                        'dataProvider' => $data,
            ]);
        } else {
            return $this->render('viewInvoice', [
                        'dataProvider' => $data,
            ]);
        }
    }

    public function actionPrint($id) {

        $model = $this->findModel($id);

        $query = new Query;
        $query->select([
                    'invoice.*',
                    'leasing.id as leasing', 'leasing.roommate_id',
                    'rooms.name as room',
                    'customers.id as customer_id', 'customers.fullname', 'customers.address', 'customers.phone',
                ])
                ->from('invoice')
                ->where(['invoice.id' => $id])
                ->join('LEFT OUTER JOIN', 'leasing', 'leasing.id = invoice.leasing_id')
                ->join('INNER JOIN', 'rooms', 'rooms.id = leasing.rooms_id')
                ->join('INNER JOIN', 'customers', 'customers.id = leasing.customers_id');

        $command = $query->createCommand();
        $data = $command->queryAll();

        $content = $this->renderPartial('print', [
            'dataProvider' => $data,
        ]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, //
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            //'format' => [210, 148.5],
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 5,
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
            'options' => ['title' => 'ใบแจ้งหนี้'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
            ]
        ]);

        $pdf->getApi()->SetJS('this.print();');

        return $pdf->render();
    }

    public function actionInvoice() {
        return $this->render('invoice');
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDeposit($leasing) {
        $model = new Invoice();
        $model->scenario = 'deposit';

        $room = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $leasing])->one();
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $leasing])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $leasing])->one();
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2->customers_id])->all();
        } else {
            $dataCustomer2 = NULL;
        }
        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer->customers_id])->all();
        $rental = \app\models\Rooms::getPrice($room->rooms_id);
        $deposit = \app\models\Rooms::getDeposit($room->rooms_id);
        $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
        $model->leasing_id = $leasing;
        $model->rental = $rental;
        $model->deposit = $deposit;
        $model->rooms_id = $room->rooms_id;

        $config = \app\models\Company::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->id = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
            $model->invoice_date = date('Y-m-d H:i:s');

            try {
                $transection = \Yii::$app->db->beginTransaction();
                //die(print_r($model));
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                    $transection->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด. กรุณาลองใหม่อีกครั้ง');
                    $transection->rollBack();
                    //return $this->redirect(['index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด.');
                //return $this->redirect(['create']);
            }
        }

        return $this->render('deposit', [
                    'model' => $model,
                    'room' => $room,
                    'customer' => $dataCustomer,
                    'config' => $config,
                    'customer2' => $dataCustomer2,
                    'room' => $room->rooms_id,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);
        //die(print_r($model));
        //$leasing = \app\models\Leasing::find()->select('id')->where(['rooms_id' => $model->leasing_id])->one();
        //$room = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $model->leasing_id])->one();
        //die(print_r($room));
        $customer = \app\models\Leasing::find()->select('customers_id')->where(['id' => $model->leasing_id])->one();
        $customer2 = \app\models\Leasing::find()->select('roommate_id')->where(['id' => $model->leasing_id])->one();
        if ($customer2 != NULL) {
            $dataCustomer2 = \app\models\Customers::find()->where(['id' => $customer2->customers_id])->all();
        } else {
            $dataCustomer2 = NULL;
        }
        //die(print_r($leasing));
        $dataCustomer = \app\models\Customers::find()->where(['id' => $customer->customers_id])->all();

        $config = \app\models\Company::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $transection = \Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                    $transection->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด. กรุณาลองใหม่อีกครั้ง');
                    $transection->rollBack();
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด. กรุณาลองใหม่อีกครั้ง');
                $transection->rollBack();
                return $this->redirect(['index']);
            }
        }

        return $this->render('_update', [
                    'model' => $model,
                    'customer' => $dataCustomer,
                    'customer2' => $dataCustomer2,
                    'config' => $config,
                        //'room' => $room,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Invoice::findOne($id)) !== null) {
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
