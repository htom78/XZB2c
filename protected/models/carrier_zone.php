<?php

    /**
     * This is the model class for table "{{carrier_zone}}".
     *
     * The followings are the available columns in table '{{carrier_zone}}':
     * @property integer $carrier_ID
     * @property integer $zone_ID
     */
    class carrier_zone extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return carrier_zone the static model class
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
            return '{{carrier_zone}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('carrier_ID, zone_ID', 'required'),
                array('carrier_ID, zone_ID', 'numerical', 'integerOnly' => true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('carrier_ID, zone_ID', 'safe', 'on' => 'search'),
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
                'carrier_ID' => 'Carrier',
                'zone_ID' => 'Zone',
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

            $criteria = new CDbCriteria;

            $criteria->compare('carrier_ID', $this->carrier_ID);

            $criteria->compare('zone_ID', $this->zone_ID);

            return new CActiveDataProvider('carrier_zone', array(
                'criteria' => $criteria,
            ));
        }

        public static function addment($carrier_ID, $zones)
        {
            if (!$carrier_ID || !$zones || !is_array($zones))
            {
                return;
            }

            foreach ($zones as $row)
            {
                $insert.="('{$carrier_ID}','{$row}'),";
            }
            $insert = trim($insert, ',');
            $req = Yii::app()->db->createCommand(
                    "INSERT INTO {{carrier_zone}} "
                    . " (`carrier_ID`,`zone_ID`) VALUES " . $insert
            );
            return $req->query();
        }

          public static function zoneDelete($carrier_ID,$zones)
        {
              if (!$carrier_ID || !$zones || !is_array($zones))
            {
                return;
            }
            $IN=trim(implode(',', $zones),',');
               $req = Yii::app()->db->createCommand(
                            "DELETE FROM {{carrier_zone}} "
                            . " WHERE zone_ID IN ({$IN}) and carrier_ID={$carrier_ID} "
            );
           $req->query();
        }

        public static function updateHook($carrier_ID, $zones)
        {
             if (!$carrier_ID || !$zones || !is_array($zones))
            {
                return;
            }
            $oldIDS=self::getZoneIDS($carrier_ID);
            if ($oldIDS)
            {
                $del = array_diff($oldIDS,$zones);
                $add = array_diff($zones, $oldIDS);
            }
            else
            {
                $add = $zones;
            }
            self::zoneDelete($carrier_ID, $del);
            self::Addment($carrier_ID, $add);
        }

        public static function getZoneIDS($carrier_ID)
        {
            $res = array();
            if (!$carrier_ID)
            {
                return $res;
            }
            $req = Yii::app()->db->createCommand(
                            "SELECT zone_ID as id FROM {{carrier_zone}} where carrier_ID={$carrier_ID}"
            );
            $res = $req->queryColumn();
            return $res;
        }
        
    }