<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "node".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $name
 * @property string $mobile
 * @property integer $start_point_city_id
 * @property string $start_point_area
 * @property string $start_point_time
 * @property integer $end_point_city_id
 * @property string $end_point_area
 * @property string $end_point_time
 * @property string $available
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Country $country
 * @property City $city
 * @property City $startPointCity
 * @property City $endPointCity
 * @property User $user
 */
class Node extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'node';
    }

	public function behaviors()
	{
	    return [
	        [
	            'class' => TimestampBehavior::className(),
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at',
	            'value' => new Expression('NOW()'),
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id', 'city_id', 'name', 'mobile', 'start_point_city_id', 'start_point_area', 'start_point_time', 'end_point_city_id', 'end_point_area', 'end_point_time', 'description'], 'filter', 'filter' => 'trim'],
            [['user_id', 'country_id', 'city_id', 'name', 'mobile', 'start_point_city_id', 'start_point_area', 'start_point_time', 'end_point_city_id', 'end_point_area', 'end_point_time', 'description'], 'required'],
            
            [['user_id', 'country_id', 'city_id', 'start_point_city_id', 'end_point_city_id'], 'integer'],
            
            [['available', 'description'], 'string'],
            ['available', 'in', 'range' => ['True', 'False']],
            
            [['name', 'start_point_area', 'end_point_area'], 'string', 'max' => 25],
            [['mobile'], 'string', 'max' => 15],
            
            [['country_id'], 			'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 	'targetAttribute' => ['country_id' 			=> 'id']],
            [['city_id'], 				'exist', 'skipOnError' => true, 'targetClass' => City::className(), 	'targetAttribute' => ['city_id' 			=> 'id']],
            [['start_point_city_id'], 	'exist', 'skipOnError' => true, 'targetClass' => City::className(), 	'targetAttribute' => ['start_point_city_id' => 'id']],
            [['end_point_city_id'], 	'exist', 'skipOnError' => true, 'targetClass' => City::className(), 	'targetAttribute' => ['end_point_city_id' 	=> 'id']],
            [['user_id'], 				'exist', 'skipOnError' => true, 'targetClass' => User::className(), 	'targetAttribute' => ['user_id' 			=> 'id']],
            
			[['start_point_time', 'end_point_time'], 'date', 'format'=>'H:i'],
			
			[['start_point_time', 'end_point_time', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> Yii::t('site', 'ID'),
            'user_id' 				=> Yii::t('site', 'User ID'),
            'country_id' 			=> Yii::t('site', 'Country'),
            'city_id' 				=> Yii::t('site', 'City'),
            'name' 					=> Yii::t('site', 'Name'),
            'mobile' 				=> Yii::t('site', 'Mobile'),
            'start_point_city_id' 	=> Yii::t('site', 'Start Point City'),
            'start_point_area' 		=> Yii::t('site', 'Start Point Area'),
            'start_point_time' 		=> Yii::t('site', 'Start Point Time'),
            'end_point_city_id' 	=> Yii::t('site', 'End Point City'),
            'end_point_area' 		=> Yii::t('site', 'End Point Area'),
            'end_point_time' 		=> Yii::t('site', 'End Point Time'),
            'available' 			=> Yii::t('site', 'Available'),
            'description' 			=> Yii::t('site', 'Description'),
            'created_at' 			=> Yii::t('site', 'Created At'),
            'updated_at' 			=> Yii::t('site', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStartPointCity()
    {
        return $this->hasOne(City::className(), ['id' => 'start_point_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndPointCity()
    {
        return $this->hasOne(City::className(), ['id' => 'end_point_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return NodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NodeQuery(get_called_class());
    }
	
	public function extraFields()
	{
	    return ['city', 'country', 'startPointCity', 'endPointCity', 'user'];
	}

}
