<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_EMAIL_INVALID=3;
	/**
	 * @var string email
	 */
	public $email;
	/**
	 * @var string password
	 */
	public $password;


    public $name;


    private $_id;

    /**
	 * Constructor.
	 * @param string email
	 * @param string password
	 */
	public function __construct($email,$password)
	{
		$this->email=$email;
		$this->password=$password;
	}
    
	public function authenticate()
	{
		  $customer=customer_entity::model()->findByAttributes(array('customer_email'=>$this->email));

        if($customer===null)
        {
            $this->errorCode=self::ERROR_EMAIL_INVALID;
        }
        else
        {

            if(!$customer->validatePassword($this->password))
            {
                 $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {
                 $this->_id=$customer->customer_ID;
                 $this->name=$customer->customer_first_name . ' ' . $customer->customer_last_name;
                $names['cart_ID']=Yii::app()->user->getState('cart_ID');
                $names['guest_ID']=Yii::app()->user->getState('guest_ID');
                $names['currency_ID']=Yii::app()->user->getState('currency_ID');
                 $this->setPersistentStates($names);
                 $this->errorCode=self::ERROR_NONE;
            }
        }
        return !$this->errorCode;

	}

    /**
	 * Returns the unique identifier for the identity.
	 * The default implementation simply returns {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the unique identifier for the identity.
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * Returns the display name for the identity.
	 * The default implementation simply returns {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the display name for the identity.
	 */
	public function getName()
	{
		return $this->name;
	}
}