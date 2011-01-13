<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $email;
    public $password;

    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
                // username and password are required
                array('email, password', 'required'),
                // rememberMe needs to be a boolean
                array('email','email'),
                array('email,password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
     
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())  // we only want to authenticate when no input errors

        {

            $this->_identity=new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();

            switch($this->_identity->errorCode)
            {
                case UserIdentity::ERROR_EMAIL_INVALID:
                    $this->addError('email','email is incorrect.');
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password','Password is incorrect.');
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration=31104000;
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}
