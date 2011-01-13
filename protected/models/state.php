<?php

/**
 * This is the model class for table "{{state}}".
 *
 * The followings are the available columns in table '{{state}}':
 * @property integer $state_ID
 * @property integer $country_ID
 * @property integer $zone_ID
 * @property string $name
 * @property string $iso_code
 * @property integer $tax_behavior
 * @property integer $active
 */
class state extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return state the static model class
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
		return '{{state}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_ID, zone_ID, name, iso_code', 'required'),
			array('country_ID, zone_ID, tax_behavior, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('iso_code', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('state_ID, country_ID, zone_ID, name, iso_code, tax_behavior, active', 'safe', 'on'=>'search'),
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
			'state_ID' => 'State',
			'country_ID' => 'Country',
			'zone_ID' => 'Zone',
			'name' => 'Name',
			'iso_code' => 'Iso Code',
			'tax_behavior' => 'Tax Behavior',
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

		$criteria->compare('state_ID',$this->state_ID);

		$criteria->compare('country_ID',$this->country_ID);

		$criteria->compare('zone_ID',$this->zone_ID);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('iso_code',$this->iso_code,true);

		$criteria->compare('tax_behavior',$this->tax_behavior);

		$criteria->compare('active',$this->active);

		return new CActiveDataProvider('state', array(
			'criteria'=>$criteria,
		));
	}

     public static function items($county_ID=null)
	{
         $add="";
         if($county_ID)
         {
             $add=" AND m1.country_ID={$county_ID} ";
         }
      
          $req = Yii::app()->db->createCommand(
                "SELECT m1.state_ID as id ,m1.name as name "
                . " FROM {{state}} AS m1 "
                . " WHERE m1.active =1 {$add}"
                . " ORDER BY m1.state_ID ASC "
        );
        $out=array();
        $res=$req->queryAll();
        foreach ($res as $row)
        {
           $out[$row['id']]=$row['name'];
        }
        return $out;

	}


    public static function item($ID)
	{
         $req = Yii::app()->db->createCommand(
                "SELECT m1.name as name "
                . " FROM {{state}} AS m1 "
                . " WHERE m1.active =1 AND m1.state_ID={$ID}"
                . " ORDER BY m1.state_ID ASC "
        );
         $res=$req->queryRow();
         if(!$res)
         {
             return ;
         }
         return $res['name'];
	}
}