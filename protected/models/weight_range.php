<?php

/**
 * This is the model class for table "{{weight_range}}".
 *
 * The followings are the available columns in table '{{weight_range}}':
 * @property integer $weight_ID
 * @property integer $carrier_ID
 * @property string $delimiter1
 * @property string $delimiter2
 */
class weight_range extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return weight_range the static model class
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
		return '{{weight_range}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carrier_ID, delimiter1, delimiter2', 'required'),
			array('carrier_ID', 'numerical', 'integerOnly'=>true),
			array('delimiter1, delimiter2', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('weight_ID, carrier_ID, delimiter1, delimiter2', 'safe', 'on'=>'search'),
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
			'weight_ID' => 'Weight',
			'carrier_ID' => 'Carrier',
			'delimiter1' => 'Delimiter1',
			'delimiter2' => 'Delimiter2',
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

		$criteria->compare('weight_ID',$this->weight_ID);

		$criteria->compare('carrier_ID',$this->carrier_ID);

		$criteria->compare('delimiter1',$this->delimiter1,true);

		$criteria->compare('delimiter2',$this->delimiter2,true);

		return new CActiveDataProvider('weight_range', array(
			'criteria'=>$criteria,
		));
	}
    
      public static function validateCarrier($weight,$carrier_ID)
    {
        if(!$weight OR !$carrier_ID)
        {
            return FALSE;
        }
         $req = Yii::app()->db->createCommand(
                    "SELECT weight_ID FROM {{weight_range}} AS m1 "
                    . " WHERE m1.carrier_ID={$carrier_ID} AND m1.delimiter1<{$weight} AND m1.delimiter2>={$weight}"
                    . " ORDER BY m1.delimiter1 DESC,m1.delimiter2"
            );
      return $req->queryScalar();
    }
}