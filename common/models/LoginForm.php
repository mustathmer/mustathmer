<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $byUserName = $this->getUser();
			//$user = $this->getUserByMobile();
            if (!$byUserName || !$byUserName->validatePassword($this->password)) {
                //$this->addError($attribute, 'Incorrect username or password.');
				
				$byEmail = $this->getUserByEmail();
				if (!$byEmail || !$byEmail->validatePassword($this->password)) {
                	//$this->addError($attribute, 'Incorrect username or password.');
					
					//$byMobile = $this->getUserByMobile();
					//if (!$byMobile || !$byMobile->validatePassword($this->password)) {
	                	$this->addError($attribute, Yii::t('site', 'Incorrect username or password.') );
					//}
				}
				
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			return Yii::$app->user->login($this->getUserByMobile(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			return Yii::$app->user->login($this->getUserByEmail(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			return $this->_user;
        } else {
            return false;
        }
    }
	
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function loginAPI()
    {
        if ($this->validate()) {
			return $this->_user;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
	
    /**
     * Finds user by [[mobile]]
     *
     * @return User|null
     */
    protected function getUserByMobile()
    {
        if ($this->_user === null) {
            $this->_user = User::findByMobile($this->username);
        }

        return $this->_user;
    }
	
    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUserByEmail()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->username);
        }

        return $this->_user;
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' 	 => Yii::t('site', 'User Name'),
            'password' 	 => Yii::t('site', 'Password'),
        ];
    }
	
}
