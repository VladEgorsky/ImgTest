<?php

namespace app\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
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
    public function actionIndex($keyword = null, $page = null)
    {
        $data = ($keyword || $page) ? $this->getIndexData($keyword, $page) : [];

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
            'sort' => false,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
        }

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    private function getIndexData($keyword, $page=null)
    {
        $requestData = [
            'engine' => 1,
            'keywords' => $keyword,
            'api_key' => 'testdev',
            'offset' => $page ? ($page*10 - 10) : 0,
            'limit' => 10,
        ];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://api3.beachinsoft.com/?r=api/search')
            ->setData($requestData)
            ->send();

        if (!$response->isOk) {
            return [];
        }

        $data = [];
        foreach ($response->data['result']['results'] as $item) {
            $data[] = [
                'id' => $item['id'],
                'image_link' => $item['image_link'],
                'image_url' => $item['image_url'],
                'description' => $item['description'],
                'author_name' => $item['author_name'],
            ];
        }

        return $data;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
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
    public function actionAbout()
    {
        return $this->render('about');
    }
}
