<?php

    /**
     * This is the model class for table "{{carrier_entity}}".
     *
     * The followings are the available columns in table '{{carrier_entity}}':
     * @property integer $carrier_ID
     * @property string $carrier_name
     * @property string $carrier_url
     * @property integer $carrier_active
     * @property integer $carrier_deleted
     * @property integer $carrier_shipping_handing
     * @property string $carrier_description
     */
    class carrier_entity extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return carrier_entity the static model class
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
            return '{{carrier_entity}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('carrier_name,carrier_active,carrier_shipping_handing', 'required'),
                array('carrier_active, carrier_deleted, carrier_shipping_handing', 'numerical', 'integerOnly' => true),
                array('carrier_name', 'length', 'max' => 64),
                array('carrier_url, carrier_description', 'length', 'max' => 255),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('carrier_ID, carrier_name, carrier_url, carrier_active, carrier_deleted, carrier_shipping_handing, carrier_description', 'safe', 'on' => 'search'),
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
                'zones'=>array(self::MANY_MANY,'zone','{{carrier_zone}}(carrier_ID,zone_ID)','condition'=>'zones.active=1'),
                'weight'=>array(self::HAS_MANY,'weight_range','carrier_ID'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'carrier_ID' => 'Carrier',
                'carrier_name' => 'Carrier Name',
                'carrier_url' => 'Carrier Url',
                'carrier_active' => 'Carrier Active',
                'carrier_deleted' => 'Carrier Deleted',
                'carrier_shipping_handing' => 'Carrier Shipping Handing',
                'carrier_description' => 'Carrier Description',
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
                    'condition' => 'carrier_deleted=2'
                ));

            $criteria->compare('carrier_ID', $this->carrier_ID);

            $criteria->compare('carrier_name', $this->carrier_name, true);

            $criteria->compare('carrier_url', $this->carrier_url, true);

            $criteria->compare('carrier_active', $this->carrier_active);

            $criteria->compare('carrier_shipping_handing', $this->carrier_shipping_handing);

            $criteria->compare('carrier_description', $this->carrier_description, true);

            return new CActiveDataProvider('carrier_entity', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            if ($this->isNewRecord)
            {
                $this->carrier_deleted = 2;
            }
            return true;
        }

        public function delete()
        {
            if (!$this->getIsNewRecord())
            {
                Yii::trace(get_class($this) . '.delete()', 'system.db.ar.CActiveRecord');
                if ($this->beforeDelete())
                {
                    $this->carrier_deleted=1;
                    $result =  $this->save();
                    $this->afterDelete();
                    return $result;
                }
                else
                    return false;
            }
            else
                throw new CDbException(Yii::t('yii', 'The active record cannot be deleted because it is new.'));
        }

        public static function items()
        {
              $req = Yii::app()->db->createCommand(
                    "SELECT m1.carrier_ID as id,m1.carrier_name as name FROM {{carrier_entity}} AS m1 "
                    . " WHERE m1.carrier_active=1 AND m1.carrier_deleted=2 "
            );
              $out=array();
           if($res=$req->queryAll());
           {
               foreach ($res as $row)
               {
                   $out[$row['id']]=$row['name'];
               }
           }
           return $out;
        }

        public static function getByZone($zone_ID)
        {
            if(!$zone_ID)
            {
                return $zone_ID;
            }
              $req = Yii::app()->db->createCommand(
                    "SELECT m1.* FROM {{carrier_entity}} AS m1 "
                    . " LEFT JOIN {{carrier_zone}} as m2 ON m1.carrier_ID=m2.carrier_ID"
                    . " WHERE m1.carrier_active=1 AND m1.carrier_deleted=2 AND m2.zone_ID={$zone_ID}"
            );
              $out=array();
           if($res=$req->queryAll());
           {
               foreach ($res as $row)
               {
                   $out[]=$row;
               }
           }
           return $out;
        }
    }