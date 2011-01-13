<?php

/**
 * This is the model class for table "{{order_entity}}".
 *
 * The followings are the available columns in table '{{order_entity}}':
 * @property integer $order_ID
 * @property integer $order_status
 * @property integer $order_carrier_ID
 * @property integer $order_cart_ID
 * @property integer $order_currency_ID
 * @property integer $order_address_ID
 * @property integer $order_customer_ID
 * @property string $order_salt
 * @property string $order_payment_method
 * @property integer $order_payment_ID
 * @property string $order_shipping_number
 * @property string $order_total_discount
 * @property string $order_total_paid
 * @property string $order_total_products
 * @property string $order_total_shipping
 * @property string $order_grand
 * @property integer $order_delivery_ID
 * @property integer $order_valid
 * @property integer $order_export
 * @property string $order_payment_date
 * @property string $order_delivery_date
 * @property string $order_create
 * @property string $order_update
 */
class order_entity extends CActiveRecord
{
    const AwaitingPayment=1;
    const PaymentAccepted=2;
    const PreparationProgress=3;
    const Shipped=4;
    const Delived=5;
    const Refund=6;
    const PaymentError=7;
    const Canceled=8;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @return order_entity the static model class
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
		return '{{order_entity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_status, order_carrier_ID, order_cart_ID, order_currency_ID, order_address_ID, order_customer_ID, order_salt, order_payment_method, order_payment_ID, order_total_discount, order_total_paid, order_total_products, order_total_shipping, order_grand, order_delivery_ID, order_valid, order_export, order_update', 'required'),
			array('order_status, order_carrier_ID, order_cart_ID, order_currency_ID, order_address_ID, order_customer_ID, order_payment_ID, order_delivery_ID, order_valid, order_export', 'numerical', 'integerOnly'=>true),
			array('order_salt, order_shipping_number', 'length', 'max'=>32),
			array('order_payment_method', 'length', 'max'=>255),
			array('order_total_discount, order_total_paid, order_total_products, order_total_shipping, order_grand', 'length', 'max'=>17),
			array('order_payment_date, order_delivery_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_ID, order_status, order_carrier_ID, order_cart_ID, order_currency_ID, order_address_ID, order_customer_ID, order_salt, order_payment_method, order_payment_ID, order_shipping_number, order_total_discount, order_total_paid, order_total_products, order_total_shipping, order_grand, order_delivery_ID, order_valid, order_export, order_payment_date, order_delivery_date, order_create, order_update', 'safe', 'on'=>'search'),
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
			'order_ID' => 'Order',
			'order_status' => 'Order Status',
			'order_carrier_ID' => 'Order Carrier',
			'order_cart_ID' => 'Order Cart',
			'order_currency_ID' => 'Order Currency',
			'order_address_ID' => 'Order Address',
			'order_customer_ID' => 'Order Customer',
			'order_salt' => 'Order Salt',
			'order_payment_method' => 'Order Payment Method',
			'order_payment_ID' => 'Order Payment',
			'order_shipping_number' => 'Order Shipping Number',
			'order_total_discount' => 'Order Total Discount',
			'order_total_paid' => 'Order Total Paid',
			'order_total_products' => 'Order Total Products',
			'order_total_shipping' => 'Order Total Shipping',
			'order_grand' => 'Order Grand',
			'order_delivery_ID' => 'Order Delivery',
			'order_valid' => 'Order Valid',
			'order_export' => 'Order Export',
			'order_payment_date' => 'Order Payment Date',
			'order_delivery_date' => 'Order Delivery Date',
			'order_create' => 'Order Create',
			'order_update' => 'Order Update',
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

		$criteria->compare('order_ID',$this->order_ID);

		$criteria->compare('order_status',$this->order_status);

		$criteria->compare('order_carrier_ID',$this->order_carrier_ID);

		$criteria->compare('order_cart_ID',$this->order_cart_ID);

		$criteria->compare('order_currency_ID',$this->order_currency_ID);

		$criteria->compare('order_address_ID',$this->order_address_ID);

		$criteria->compare('order_customer_ID',$this->order_customer_ID);

		$criteria->compare('order_salt',$this->order_salt,true);

		$criteria->compare('order_payment_method',$this->order_payment_method,true);

		$criteria->compare('order_payment_ID',$this->order_payment_ID);

		$criteria->compare('order_shipping_number',$this->order_shipping_number,true);

		$criteria->compare('order_total_discount',$this->order_total_discount,true);

		$criteria->compare('order_total_paid',$this->order_total_paid,true);

		$criteria->compare('order_total_products',$this->order_total_products,true);

		$criteria->compare('order_total_shipping',$this->order_total_shipping,true);

		$criteria->compare('order_grand',$this->order_grand,true);

		$criteria->compare('order_delivery_ID',$this->order_delivery_ID);

		$criteria->compare('order_valid',$this->order_valid);

		$criteria->compare('order_export',$this->order_export);

		$criteria->compare('order_payment_date',$this->order_payment_date,true);

		$criteria->compare('order_delivery_date',$this->order_delivery_date,true);

		$criteria->compare('order_create',$this->order_create,true);

		$criteria->compare('order_update',$this->order_update,true);

		return new CActiveDataProvider('order_entity', array(
			'criteria'=>$criteria,
		));
	}

     protected function beforeValidate()
        {
            if ($this->isNewRecord)
            {
                   $this->order_valid=1;
                 $this->order_export=2;
            }
            $this->order_update=date('Y-m-d H:i:s');
            return true;
        }
}