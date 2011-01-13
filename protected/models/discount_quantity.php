<?php

/**
 * This is the model class for table "{{discount_quantity}}".
 *
 * The followings are the available columns in table '{{discount_quantity}}':
 * @property integer $quantity_ID
 * @property integer $discount_type_ID
 * @property integer $product_ID
 * @property string $value
 * @property integer $quantity
 */
class discount_quantity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return discount_quantity the static model class
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
		return '{{discount_quantity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discount_type_ID, product_ID, value, quantity', 'required'),
			array('discount_type_ID, product_ID, quantity', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('quantity_ID, discount_type_ID, product_ID, value, quantity', 'safe', 'on'=>'search'),
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
			'quantity_ID' => 'Quantity',
			'discount_type_ID' => 'Discount Type',
			'product_ID' => 'Product',
			'value' => 'Value',
			'quantity' => 'Quantity',
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

		$criteria->compare('quantity_ID',$this->quantity_ID);

		$criteria->compare('discount_type_ID',$this->discount_type_ID);

		$criteria->compare('product_ID',$this->product_ID);

		$criteria->compare('value',$this->value,true);

		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider('discount_quantity', array(
			'criteria'=>$criteria,
		));
	}

    public function applyRule($price)
    {
        
        if($price<=0)
        {
            return 0;
        }
        if($this->discount_type_ID==1)
        {
            //percent discount
            return round($price*(1-$this->value/100),2);

        }
        else if($this->discount_type_ID==2)
        {
            $temp=$price-$this->value;
  
            return ($temp <=0) ? round($price,2):round($temp,2);
        }
        else
        {
            return round($price,2);
        }
        
    }

     public static function item($product_ID)
        {
            if (!$product_ID)
            {
                return;
            }
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.* "
                    . " FROM {{discount_quantity}} AS m1 "
                    . " WHERE m1.product_ID={$product_ID} "
                    . " ORDER BY m1.quantity DESC,m1.value DESC"
            );
            return $req->queryAll();
        }

        public static function validateQuantityDiscount($product_ID,$quantity)
        {
             if (!$product_ID || intval($quantity)<=0)
            {
                return false;
            }
            
              $req = Yii::app()->db->createCommand(
                    "SELECT m1.quantity_ID as id"
                    . " FROM {{discount_quantity}} AS m1 "
                    . " WHERE m1.product_ID={$product_ID} AND m1.quantity<={$quantity}"
                    . " ORDER BY m1.quantity DESC,m1.value DESC"
            );
       
         $res=$req->queryRow();
         
         if(!$res)
         {
             return false;
         }
       
         return $res['id'];
        }


    }