<?php

namespace app\controllers;
use app\models\Users;
use app\models\UsersAddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\UsersAddressManager\UsersAddressInterface;
use yii\di\Container;
use Yii;

class UsersAddressController extends Controller
{
    protected $finder;
    public function __construct($id, $module, UsersAddressInterface $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    
    public function actionIndex()
    {
        
        $model = $this->finder->index();
        
        return $this->render('index', $model);
    }


    public function actionView($id)
    {
        $model = $this->finder->view($id);
        if(!empty($model)){
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }


    public function actionCreate()
    {
        $model = $this->finder->create();
        if(isset($model->id))
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->finder->update($id);
        if(isset($model->id))
        {
            return $this->render('update', [
            'model' => $model,
            ]);
        }    
        
    }
    public function actionDelete($id)
    {
        $model = $this->finder->delete($id);
        if($model == 1)
        {
            return $this->redirect(['index']);
        }
        return $this->redirect(['index']);
    }
}

//$container = new Container;
Yii::$container->set('app\UsersAddressManager\UsersAddressInterface', 'app\UsersAddressManager\UsersAddressManager');