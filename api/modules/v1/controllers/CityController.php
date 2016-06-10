<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Mohammad Mousa <mohammad.riad@gmail.com>
 */
class CityController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
	public $modelClass = 'common\models\City';
	
	public function actions() 
	{ 
	    $actions = parent::actions();
	    $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
	    return $actions;
	}
	
	public function prepareDataProvider() 
	{
	    $searchModel = new \common\models\CitySearchAPI;    
	    return $searchModel->search(\Yii::$app->request->queryParams);
	}
	    
}