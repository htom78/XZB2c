<?php

/**
 * This is the model class for table "{{order_discount}}".
 *
 * The followings are the available columns in table '{{order_discount}}':
 * @property integer $ID
 * @property integer $order_ID
 * @property integer $discount_ID
 * @property string $discount_name
 * @property string $discount_value
 */
class order_discount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return order_discount the static model class
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
		return '{{order_discount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_ID, discount_ID, discount_name, discount_value', 'required'),
			array('order_ID, discount_ID', 'numerical', 'integerOnly'=>true),
			array('discount_name', 'length', 'max'=>32),
			array('discount_value', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, order_ID, discount_ID, discount_name, discount_value', 'safe', 'on'=>'search'),
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
			'ID' => 'Id',
			'order_ID' => 'Order',
			'discount_ID' => 'Discount',
			'discount_name' => 'Discount Name',
			'discount_value' => 'Discount Value',
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

		$criteria->compare('ID',$this->ID);

		$criteria->compare('order_ID',$this->order_ID);

		$criteria->compare('discount_ID',$this->discount_ID);

		$criteria->compare('discount_name',$this->discount_name,true);

		$criteria->compare('discount_value',$this->discount_value,true);

		return new CActiveDataProvider('order_discount', array(
			'criteria'=>$criteria,
		));
	}

    public static function nbDiscountCustomer($customer_ID, $discount_ID)
    {
        if(!$customer_ID OR !$discount_ID)
        {
            return 0;
        }
          $req=Yii::app()->db->createCommand(
                'SELECT count(m1.ID) FROM {{order_discount}} as m1 '
               .  " LEFT JOIN {{order_entity}} as m2 ON m1.order_ID=m2.order_ID "
               . " WHERE m2.order_customer_ID={$customer_ID} AND m1.discount_ID={$discount_ID} AND m2.order_valid=1 "
              );
          return  $req->queryScalar();

    }
}