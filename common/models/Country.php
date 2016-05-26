<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $iso_code
 *
 * @property City[] $cities
 * @property User[] $users
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
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
        	[['name_ar', 'name_en', 'iso_code'], 'filter', 'filter' => 'trim'],
            [['name_ar', 'name_en', 'iso_code'], 'required'],
            
            [['name_ar', 'name_en'], 'string', 'max' => 25],
            ['iso_code', 'string', 'max' => 3, 'min' => 3],
            
            [['name_ar', 'name_en', 'iso_code'], 'unique', 'targetAttribute' => ['name_ar', 'name_en', 'iso_code'], 'message' => Yii::t('site', 'The combination of Arabic Country name, English Country name and Iso Code has already been taken.')],
            
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
            'name_ar' 	 => Yii::t('site', 'Arabic Country Name'),
            'name_en' 	 => Yii::t('site', 'English Country Name'),
            'iso_code' 	 => Yii::t('site', 'Iso Code'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
	
	public function extraFields()
	{
	    return ['users'];
	}
	
}
