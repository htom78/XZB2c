<?php

/**
 * This is the model class for table "{{order_detail}}".
 *
 * The followings are the available columns in table '{{order_detail}}':
 * @property integer $detail_ID
 * @property integer $detail_order_ID
 * @property integer $detail_product_ID
 * @property string $detail_product_name
 * @property integer $detail_product_quantity
 * @property string $detail_product_price
 * @property string $detail_reducetion_percent
 * @property string $detail_reducetion_amount
 * @property string $detail_quantity_discount
 * @property double $detail_weight
 * @property integer $detail_quantity_discount_applied
 */
class order_detail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return order_detail the static model class
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
		return '{{order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('detail_order_ID, detail_product_ID, detail_product_name, detail_product_quantity, detail_product_price, detail_reducetion_percent, detail_reducetion_amount, detail_quantity_discount, detail_weight, detail_quantity_discount_applied', 'required'),
			array('detail_order_ID, detail_product_ID, detail_product_quantity, detail_quantity_discount_applied', 'numerical', 'integerOnly'=>true),
			array('detail_weight', 'numerical'),
			array('detail_product_name', 'length', 'max'=>255),
			array('detail_product_price, detail_reducetion_amount, detail_quantity_discount', 'length', 'max'=>20),
			array('detail_reducetion_percent', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detail_ID, detail_order_ID, detail_product_ID, detail_product_name, detail_product_quantity, detail_product_price, detail_reducetion_percent, detail_reducetion_amount, detail_quantity_discount, detail_weight, detail_quantity_discount_applied', 'safe', 'on'=>'search'),
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
			'detail_ID' => 'Detail',
			'detail_order_ID' => 'Detail Order',
			'detail_product_ID' => 'Detail Product',
			'detail_product_name' => 'Detail Product Name',
			'detail_product_quantity' => 'Detail Product Quantity',
			'detail_product_price' => 'Detail Product Price',
			'detail_reducetion_percent' => 'Detail Reducetion Percent',
			'detail_reducetion_amount' => 'Detail Reducetion Amount',
			'detail_quantity_discount' => 'Detail Quantity Discount',
			'detail_weight' => 'Detail Weight',
			'detail_quantity_discount_applied' => 'Detail Quantity Discount Applied',
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

		$criteria->compare('detail_ID',$this->detail_ID);

		$criteria->compare('detail_order_ID',$this->detail_order_ID);

		$criteria->compare('detail_product_ID',$this->detail_product_ID);

		$criteria->compare('detail_product_name',$this->detail_product_name,true);

		$criteria->compare('detail_product_quantity',$this->detail_product_quantity);

		$criteria->compare('detail_product_price',$this->detail_product_price,true);

		$criteria->compare('detail_reducetion_percent',$this->detail_reducetion_percent,true);

		$criteria->compare('detail_reducetion_amount',$this->detail_reducetion_amount,true);

		$criteria->compare('detail_quantity_discount',$this->detail_quantity_discount,true);

		$criteria->compare('detail_weight',$this->detail_weight);

		$criteria->compare('detail_quantity_discount_applied',$this->detail_quantity_discount_applied);

		return new CActiveDataProvider('order_detail', array(
			'criteria'=>$criteria,
		));
	}
}