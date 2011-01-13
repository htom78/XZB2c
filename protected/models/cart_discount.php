<?php

/**
 * This is the model class for table "{{cart_discount}}".
 *
 * The followings are the available columns in table '{{cart_discount}}':
 * @property integer $cart_ID
 * @property integer $discount_ID
 */
class cart_discount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return cart_discount the static model class
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
		return '{{cart_discount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cart_ID, discount_ID', 'required'),
			array('cart_ID, discount_ID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cart_ID, discount_ID', 'safe', 'on'=>'search'),
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
			'discount_ID' => 'Discount',
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

		$criteria->compare('discount_ID',$this->discount_ID);

		return new CActiveDataProvider('cart_discount', array(
			'criteria'=>$criteria,
		));
	}

     public static function items($cart_ID)
	{
         $req = Yii::app()->db->createCommand(
                   "SELECT m2.* "
                . " FROM {{cart_discount}} AS m1 "
                . " LEFT JOIN {{discount_entity}} as m2 ON m2.discount_ID=m1.discount_ID"
                . " WHERE m1.cart_ID={$cart_ID}"
        );
         $res=$req->queryAll();
         if(!$res)
         {
             return ;
         }
         $dump=array();
         foreach($res as $row)
         {
             $dump[$row['discount_ID']]=$row;
         }
         return $dump;
	}
}