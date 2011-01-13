<?php

/**
 * This is the model class for table "{{guest}}".
 *
 * The followings are the available columns in table '{{guest}}':
 * @property integer $id_guest
 * @property string $operating_system
 * @property string $web_browser
 * @property integer $customer_ID
 * @property integer $javascript
 * @property integer $screen_resolution_x
 * @property integer $screen_resolution_y
 * @property integer $screen_color
 * @property integer $sun_java
 * @property integer $adobe_flash
 * @property integer $adobe_director
 * @property integer $apple_quicktime
 * @property integer $real_player
 * @property integer $windows_media
 * @property string $accept_language
 */
class guest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return guest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{guest}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_ID, javascript, screen_resolution_x, screen_resolution_y, screen_color, sun_java, adobe_flash, adobe_director, apple_quicktime, real_player, windows_media', 'numerical', 'integerOnly'=>true),
			array('operating_system, web_browser', 'length', 'max'=>128),
			array('accept_language', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_guest, operating_system, web_browser, customer_ID, javascript, screen_resolution_x, screen_resolution_y, screen_color, sun_java, adobe_flash, adobe_director, apple_quicktime, real_player, windows_media, accept_language', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_guest' => 'Id Guest',
			'operating_system' => 'Operating System',
			'web_browser' => 'Web Browser',
			'customer_ID' => 'Customer',
			'javascript' => 'Javascript',
			'screen_resolution_x' => 'Screen Resolution X',
			'screen_resolution_y' => 'Screen Resolution Y',
			'screen_color' => 'Screen Color',
			'sun_java' => 'Sun Java',
			'adobe_flash' => 'Adobe Flash',
			'adobe_director' => 'Adobe Director',
			'apple_quicktime' => 'Apple Quicktime',
			'real_player' => 'Real Player',
			'windows_media' => 'Windows Media',
			'accept_language' => 'Accept Language',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_guest',$this->id_guest);

		$criteria->compare('operating_system',$this->operating_system,true);

		$criteria->compare('web_browser',$this->web_browser,true);

		$criteria->compare('customer_ID',$this->customer_ID);

		$criteria->compare('javascript',$this->javascript);

		$criteria->compare('screen_resolution_x',$this->screen_resolution_x);

		$criteria->compare('screen_resolution_y',$this->screen_resolution_y);

		$criteria->compare('screen_color',$this->screen_color);

		$criteria->compare('sun_java',$this->sun_java);

		$criteria->compare('adobe_flash',$this->adobe_flash);

		$criteria->compare('adobe_director',$this->adobe_director);

		$criteria->compare('apple_quicktime',$this->apple_quicktime);

		$criteria->compare('real_player',$this->real_player);

		$criteria->compare('windows_media',$this->windows_media);

		$criteria->compare('accept_language',$this->accept_language,true);

		return new CActiveDataProvider('guest', array(
			'criteria'=>$criteria,
		));
	}
    
       public static function AddGuest()
    {
        
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$acceptLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
        $operating_system= self::getOs($userAgent);
        $web_browser= self::getBrowser($userAgent);
		$accept_language = self::getLanguage($acceptLanguage);
         $req = Yii::app()->db->createCommand(
                            "INSERT INTO {{guest}} "
                            . " (`operating_system`,`web_browser`,`accept_language`) VALUES ('{$operating_system}','{$web_browser}','{$acceptLanguage}')"
            );
          $req->execute();
       return Yii::app()->db->commandBuilder->getLastInsertID('{{guest}}');
    }

    public static function mergerCustomer($customer_ID,$guest_ID)
    {
        if(!$customer_ID)
        {
            return FALSE;
        }
        $req=Yii::app()->db->createCommand(
                        'UPDATE {{guest}}'
                        . " SET customer_ID='{$customer_ID}' WHERE id_guest={$guest_ID}"
            );
       $req->execute();
       
         $req=Yii::app()->db->createCommand(
                        'UPDATE {{cart}} '
                      . " SET cart_customer_ID='{$customer_ID}' WHERE cart_guest_ID={$guest_ID}"
             );       

       return $req->execute();
    }



    private static  function getLanguage($acceptLanguage)
	{
		// $langsArray is filled with all the languages accepted, ordered by priority
		$langsArray = array();
		preg_match_all('/([a-z]{2}(-[a-z]{2})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/', $acceptLanguage, $array);
		if (count($array[1]))
		{
			$langsArray = array_combine($array[1], $array[4]);
			foreach ($langsArray as $lang => $val)
				if ($val === '')
					$langsArray[$lang] = 1;
			arsort($langsArray, SORT_NUMERIC);
		}

		// Only the first language is returned
		return (sizeof($langsArray) ? key($langsArray) : '');
	}

	private static  function getBrowser($userAgent)
	{
		$browserArray = array(
			'Google Chrome' => 'Chrome/',
			'Safari' => 'Safari',
			'Firefox 3.x' => 'Firefox/3',
			'Firefox 2.x' => 'Firefox/2',
			'Opera' => 'Opera',
			'IE 8.x' => 'MSIE 8',
			'IE 7.x' => 'MSIE 7',
			'IE 6.x' => 'MSIE 6'
		);
		foreach ($browserArray as $k => $value)
			if (strstr($userAgent, $value))
			{
				return $k;
					
			}
		return NULL;
	}

	private static  function getOs($userAgent)
	{
		$osArray = array(
			'Windows Vista' => 'Windows NT 6',
			'Windows XP' => 'Windows NT 5',
			'MacOsX' => 'Mac OS X',
			'Linux' => 'X11'
		);
		foreach ($osArray as $k => $value)
			if (strstr($userAgent, $value))
			{
				return $k;
			}
		return NULL;
	}
}