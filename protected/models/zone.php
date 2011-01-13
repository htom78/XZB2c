<?php

/**
 * This is the model class for table "{{zone}}".
 *
 * The followings are the available columns in table '{{zone}}':
 * @property integer $zone_ID
 * @property string $name
 * @property integer $active
 */
class zone extends CActiveRecord
{
    	private static $_items=array();
	/**
	 * Returns the static model of the specified AR class.
	 * @return zone the static model class
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
		return '{{zone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zone_ID, name, active', 'safe', 'on'=>'search'),
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
			'zone_ID' => 'Zone',
			'name' => 'Name',
			'active' => 'Active',
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

		$criteria->compare('zone_ID',$this->zone_ID);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('active',$this->active);

		return new CActiveDataProvider('zone', array(
			'criteria'=>$criteria,
		));
	}


	public static function items()
	{
        
		if(!isset(self::$_items) || !self::$_items)
			self::loadItems();
		return self::$_items;
	}

	public static function item($ID)
	{
      
		if(!isset(self::$_items) || !self::$_items)
			self::loadItems();
		return isset(self::$_items[$ID]) ? self::$_items[$ID] : false;
	}

	
	private static function loadItems()
	{
		self::$_items=array();
		$models=self::model()->findAll();
		foreach($models as $model)
			self::$_items[$model->zone_ID]=$model->name;
	}

}