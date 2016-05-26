<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name_ar
 * @property string $name_en
 *
 * @property Country $country
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
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
        	[['name_ar', 'name_en'], 'filter', 'filter' => 'trim'],
            [['country_id', 'name_ar', 'name_en'], 'required'],
            
			[['country_id', 'name_ar', 'name_en'], 'unique', 'targetAttribute' => ['country_id', 'name_ar', 'name_en'], 'message' => Yii::t('site', 'The combination of Country ID, Arabic City name and English city name has already been taken.')],
			
            [['country_id'], 'integer'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            
			[['name_ar', 'name_en'], 'string', 'max' => 25],
			
			[['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 		 => Yii::t('site', 'ID'),
            'country_id' => Yii::t('site', 'Country'),
            'name_ar' 	 => Yii::t('site', 'Arabic City Name'),
            'name_en' 	 => Yii::t('site', 'English City Name'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
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
    public function getNodes()
    {
        return $this->hasMany(Node::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStartPointNodes()
    {
        return $this->hasMany(Node::className(), ['start_point_city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndPointNodes()
    {
        return $this->hasMany(Node::className(), ['end_point_city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['city_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
	
	public function extraFields()
	{
	    return ['country', 'users', 'nodes', 'startPointNodes', 'endPointNodes'];
	}

}
