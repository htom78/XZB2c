<?php

/**
 * This is the model class for table "{{delivery}}".
 *
 * The followings are the available columns in table '{{delivery}}':
 * @property integer $delivery_ID
 * @property integer $carrier_ID
 * @property integer $zone_ID
 * @property integer $weight_range_ID
 * @property string $price
 */
class delivery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return delivery the static model class
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
		return '{{delivery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carrier_ID, zone_ID, weight_range_ID, price', 'required'),
			array('carrier_ID, zone_ID, weight_range_ID', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('delivery_ID, carrier_ID, zone_ID, weight_range_ID, price', 'safe', 'on'=>'search'),
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
			'delivery_ID' => 'Delivery',
			'carrier_ID' => 'Carrier',
			'zone_ID' => 'Zone',
			'weight_range_ID' => 'Weight Range',
			'price' => 'Price',
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

		$criteria->compare('delivery_ID',$this->delivery_ID);

		$criteria->compare('carrier_ID',$this->carrier_ID);

		$criteria->compare('zone_ID',$this->zone_ID);

		$criteria->compare('weight_range_ID',$this->weight_range_ID);

		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider('delivery', array(
			'criteria'=>$criteria,
		));
	}
}