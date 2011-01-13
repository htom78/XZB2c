<?php

/**
 * This is the model class for table "{{address_entity}}".
 *
 * The followings are the available columns in table '{{address_entity}}':
 * @property integer $address_ID
 * @property integer $address_state_ID
 * @property integer $address_country_ID
 * @property integer $address_customer_ID
 * @property string $address_alias
 * @property string $address_company
 * @property string $address_lastname
 * @property string $address_firstname
 * @property string $address_address1
 * @property string $address_address2
 * @property string $address_postcode
 * @property string $address_city
 * @property string $address_other
 * @property string $address_phone
 * @property integer $address_active
 * @property integer $address_deleted
 * @property string $address_create
 * @property string $address_update
 */
class address_entity extends CActiveRecord
{
    public $address_customer_email;
	/**
	 * Returns the static model of the specified AR class.
	 * @return address_entity the static model class
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
		return '{{address_entity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address_country_ID, address_customer_ID, address_alias, address_lastname, address_firstname, address_address1, address_city, address_active, address_deleted', 'required'),
			array('address_state_ID, address_country_ID, address_customer_ID, address_active, address_deleted', 'numerical', 'integerOnly'=>true),
			array('address_alias, address_company, address_lastname, address_firstname', 'length', 'max'=>32),
			array('address_address1, address_address2', 'length', 'max'=>128),
			array('address_postcode, address_city', 'length', 'max'=>12),
			array('address_other', 'length', 'max'=>64),
			array('address_phone', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('address_ID, address_state_ID, address_country_ID, address_customer_ID, address_alias, address_company, address_lastname, address_firstname, address_address1, address_address2, address_postcode, address_city, address_other, address_phone, address_active, address_deleted, address_update', 'safe', 'on'=>'search'),
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
			'address_ID' => 'Address',
			'address_state_ID' => 'Address State',
			'address_country_ID' => 'Address Country',
			'address_customer_ID' => 'Address Customer',
			'address_alias' => 'Address Alias',
			'address_company' => 'Address Company',
			'address_lastname' => 'Address Lastname',
			'address_firstname' => 'Address Firstname',
			'address_address1' => 'Address Address1',
			'address_address2' => 'Address Address2',
			'address_postcode' => 'Address Postcode',
			'address_city' => 'Address City',
			'address_other' => 'Address Other',
			'address_phone' => 'Address Phone',
			'address_active' => 'Address Active',
			'address_deleted' => 'Address Deleted',
			'address_create' => 'Address Create',
			'address_update' => 'Address Update',
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

		$criteria=new CDbCriteria(array(
                    'condition' => 'address_deleted=2'
                ));

		$criteria->compare('address_ID',$this->address_ID);

		$criteria->compare('address_state_ID',$this->address_state_ID);

		$criteria->compare('address_country_ID',$this->address_country_ID);

		$criteria->compare('address_customer_ID',$this->address_customer_ID);

		$criteria->compare('address_alias',$this->address_alias,true);

		$criteria->compare('address_lastname',$this->address_lastname,true);

		$criteria->compare('address_firstname',$this->address_firstname,true);

		$criteria->compare('address_postcode',$this->address_postcode,true);

		$criteria->compare('address_city',$this->address_city,true);

		$criteria->compare('address_active',$this->address_active);

		return new CActiveDataProvider('address_entity', array(
			'criteria'=>$criteria,
		));
	}

      protected function beforeValidate()
        {
            if ($this->isNewRecord)
            {
                $this->address_deleted = 2;
            }
            $this->address_update = date('Y-m-d H:i:s');
            return true;
        }

         public function delete()
        {
            if (!$this->getIsNewRecord())
            {
                Yii::trace(get_class($this) . '.delete()', 'system.db.ar.CActiveRecord');
                if ($this->beforeDelete())
                {
                    $this->address_deleted = 1;
                    $result = $this->save();
                    $this->afterDelete();
                    return $result;
                }
                else
                    return false;
            }
            else
                throw new CDbException(Yii::t('yii', 'The active record cannot be deleted because it is new.'));
        }

        public static function items($customerID)
        {
            if(!$customerID)
            {
                return ;
            }
              $req = Yii::app()->db->createCommand(
                    'SELECT m1.address_ID,m1.address_alias FROM {{address_entity}} as m1 '
                    . " WHERE m1.address_customer_ID={$customerID} AND m1.address_active=1 AND m1.address_deleted=2 "
                    . " ORDER BY m1.address_update DESC"
            );
            $res=$req->queryAll();
            $out=array();
            if($res)
            {
                foreach($res as $row)
                {
                    $out[$row['address_ID']]=$row['address_alias'];
                }
            }
            return $out;
        }

        public function getZoneId()
        {
            $req=Yii::app()->db->createCommand(
                'SELECT m1.zone_ID FROM {{country}} AS m1 '
               ." WHERE m1.country_ID={$this->address_country_ID}"
                );
             return $req->queryScalar();
        }
    }