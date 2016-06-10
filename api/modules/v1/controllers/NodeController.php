<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Mohammad Mousa <mohammad.riad@gmail.com>
 */
class NodeController extends ActiveController
{
	public $modelClass = 'common\models\Node';
	
	public function actions() 
	{ 
	    $actions = parent::actions();
	    $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
	    return $actions;
	}
	
	public function prepareDataProvider() 
	{
	    $searchModel = new \common\models\NodeSearchAPI;    
	    return $searchModel->search(\Yii::$app->request->queryParams);
	}
	
}


