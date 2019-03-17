<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'error', 'logout', 'report', 'energies', 'developer'],
                'rules' => [
                    [
                        'actions' => ['index', 'error', 'logout', 'report', 'energies', 'developer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $building = \app\models\Building::find()->all();

        $invoice = \app\models\Invoice::find()->where(['status' => 'รอการชำระ'])->all();
        return $this->render('index', [
                    'building' => $building,
                    'invoice' => $invoice,
        ]);
    }

    public function actionReport() {
        $receipt = new \app\models\Receipt();
        $exp = new \app\models\Expenses();
        // สรุปยอดรายรับ
        $summary_report = $receipt->getSummary_income();
        // สรุปยอดรายจ่าย
        $summary_exp = $exp->getSummary_exp();

        return $this->render('report', [
                    'summary_report' => $summary_report,
                    'summary_exp' => $summary_exp,
        ]);
    }

    public function actionEnergies() {
        //$receipt = new \app\models\Receipt();
        //$summary = $receipt->getEnergiesexp();
        $building = \app\models\Building::find()->all();
        return $this->render('energies', [
                    'building' => $building,
        ]);
    }
    
     public function actionDeveloper() {
        return $this->render('developer');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goHome();
            }

            //$model->password = '';
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string

      public function actionContact() {
      $model = new ContactForm();
      if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
      }
      return $this->render('contact', [
      'model' => $model,
      ]);
      }

      /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
