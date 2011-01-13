<?php

    /**
     * This is the model class for table "{{customer_entity}}".
     *
     * The followings are the available columns in table '{{customer_entity}}':
     * @property integer $customer_ID
     * @property integer $customer_gender
     * @property integer $customer_default_group_ID
     * @property string $customer_salt
     * @property string $customer_email
     * @property string $customer_password
     * @property string $customer_last_name
     * @property string $customer_first_name
     * @property integer $customer_active
     * @property integer $customer_deleted
     * @property string $customer_create
     * @property string $customer_update
     */
    class customer_entity extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return customer_entity the static model class
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
            return '{{customer_entity}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('customer_gender, customer_default_group_ID, customer_salt, customer_email, customer_password, customer_last_name, customer_first_name, customer_active, customer_deleted', 'required'),
                array('customer_gender, customer_default_group_ID, customer_active, customer_deleted', 'numerical', 'integerOnly' => true),
                array('customer_salt,customer_last_name, customer_first_name', 'length', 'max' => 32),
                array('customer_password','length','min'=>8,'max'=>32),
                array('customer_email', 'length', 'max' => 128),
                array('customer_email', 'email'),
                array('customer_email', 'unique'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('customer_ID, customer_gender, customer_default_group_ID, customer_salt, customer_email, customer_password, customer_last_name, customer_first_name, customer_active, customer_deleted, customer_create, customer_update', 'safe', 'on' => 'search'),
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
                'customer_ID' => 'Customer',
                'customer_gender' => 'Customer Gender',
                'customer_default_group_ID' => 'Customer Default Group',
                'customer_salt' => 'Customer Salt',
                'customer_email' => 'Customer Email',
                'customer_password' => 'Customer Password',
                'customer_last_name' => 'Customer Last Name',
                'customer_first_name' => 'Customer First Name',
                'customer_active' => 'Customer Active',
                'customer_deleted' => 'Customer Deleted',
                'customer_create' => 'Customer Create',
                'customer_update' => 'Customer Update',
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

            $criteria = new CDbCriteria(array(
                    'condition' => 'customer_deleted=2'
                ));

            $criteria->compare('customer_ID', $this->customer_ID);

            $criteria->compare('customer_gender', $this->customer_gender);

            $criteria->compare('customer_default_group_ID', $this->customer_default_group_ID);

            $criteria->compare('customer_email', $this->customer_email, true);

            $criteria->compare('customer_last_name', $this->customer_last_name, true);

            $criteria->compare('customer_first_name', $this->customer_first_name, true);

            $criteria->compare('customer_active', $this->customer_active);


            return new CActiveDataProvider('customer_entity', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            if ($this->isNewRecord)
            {
                $this->customer_deleted = 2;
                $this->customer_salt = md5(time());
               
            }
            $this->customer_update = date('Y-m-d H:i:s');
            return true;
        }

        protected function afterSave()
        {
            if($this->isNewRecord)
            {
             $this->customer_password = $this->hashPassword($this->customer_salt, $this->customer_password);
             $this->setIsNewRecord(FALSE);
         
             $this->save();
            }
           
            if ($this->hasEventHandler('onAfterSave'))
                $this->onAfterSave(new CEvent($this));
        }

        public  function setPassword($password)
        {
            $this->customer_password = $this->hashPassword($this->customer_salt, $password);
            $this->update();
        }

        public function validatePassword($password)
        {
          return $this->customer_password==$this->hashPassword($this->customer_salt, $password) ? TRUE :FALSE;
        }

        private static function hashPassword($salt, $password)
        {
            return md5($salt . $password);
        }

        public function delete()
        {
            if (!$this->getIsNewRecord())
            {
                Yii::trace(get_class($this) . '.delete()', 'system.db.ar.CActiveRecord');
                if ($this->beforeDelete())
                {
                    $this->customer_deleted = 1;
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

        public function suggestEmail($keyword,$limit=20)
	{
		$email=$this->findAll(array(
			'condition'=>'customer_email LIKE :keyword',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($email as $item)
			$names[]=$item->customer_email;
		return $names;
	}

    }