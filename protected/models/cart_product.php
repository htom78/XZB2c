<?php

/**
 * This is the model class for table "{{cart_product}}".
 *
 * The followings are the available columns in table '{{cart_product}}':
 * @property integer $cart_ID
 * @property integer $product_ID
 * @property integer $quantity
 * @property string $create
 */
class cart_product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return cart_product the static model class
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
		return '{{cart_product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cart_ID, product_ID, create', 'required'),
			array('cart_ID, product_ID, quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cart_ID, product_ID, quantity, create', 'safe', 'on'=>'search'),
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
			'cart_ID' => 'Cart',
			'product_ID' => 'Product',
			'quantity' => 'Quantity',
			'create' => 'Create',
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

		$criteria->compare('cart_ID',$this->cart_ID);

		$criteria->compare('product_ID',$this->product_ID);

		$criteria->compare('quantity',$this->quantity);

		$criteria->compare('create',$this->create,true);

		return new CActiveDataProvider('cart_product', array(
			'criteria'=>$criteria,
		));
	}

     
}