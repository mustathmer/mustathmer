<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Country Controller API
 *
 * @author Mohammad Mousa <mohammad.riad@gmail.com>
 */
class UserController extends ActiveController
{
	public $modelClass = 'common\models\User'; 
	
	
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

	public function prepareDataProvider() 
	{
	    $searchModel = new \common\models\UserSearchAPI;    
	    return $searchModel->search(\Yii::$app->request->queryParams);
	}

    public function actionCreate(){
    	
        //$model = new $this->modelClass([
        //    'scenario' => $this->scenario,
        //]);
        
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
		
		$model->setPassword($model->password);
        $model->generateAuthKey();
		
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
				
    }
	
	public function actionLogin() {
        $model = new \common\models\LoginForm();
		
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
		if( $model->loginAPI() ){
			return $model->loginAPI();
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        
		return $model;
	}
	   
}


