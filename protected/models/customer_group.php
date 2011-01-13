<?php

    /**
     * This is the model class for table "{{customer_group}}".
     *
     * The followings are the available columns in table '{{customer_group}}':
     * @property integer $customer_ID
     * @property integer $group_ID
     */
    class customer_group extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return customer_group the static model class
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
            return '{{customer_group}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('customer_ID, group_ID', 'required'),
                array('customer_ID, group_ID', 'numerical', 'integerOnly' => true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('customer_ID, group_ID', 'safe', 'on' => 'search'),
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
                'group_ID' => 'Group',
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

            $criteria->compare('customer_ID', $this->customer_ID);

            $criteria->compare('group_ID', $this->group_ID);

            return new CActiveDataProvider('customer_group', array(
                'criteria' => $criteria,
            ));
        }

        public static function addment($customer_ID, $groups, $default)
        {

            if (!$customer_ID || !$default)
            {
                return;
            }

            if (!$groups || !in_array($default, $groups))
            {
                $groups[] = $default;
            }

            foreach ($groups as $row)
            {
                $insert.="('{$customer_ID}','{$row}'),";
            }
            $insert = trim($insert, ',');
            $req = Yii::app()->db->createCommand(
                    "INSERT INTO {{customer_group}} "
                    . " (`customer_ID`,`group_ID`) VALUES " . $insert
            );
            return $req->query();
        }

        public static function updateItem($customer_ID, $groups, $default)
        {
            if (!$customer_ID || !$groups || !$default || !is_array($groups))
            {
                return;
            }
            $oldIDS = self::customerGroups($customer_ID);

            if (!in_array($default, $groups))
            {
                $groups[] = $default;
            }

            if ($oldIDS)
            {
                $del = array_diff($oldIDS, $groups);
                $add = array_diff($groups, $oldIDS);
            }
            else
            {
                $add = $groups;
            }

            self::deleteItem($customer_ID, $del);

            if ($add)
            {
                foreach ($add as $row)
                {
                    $insert.="('{$customer_ID}','{$row}'),";
                }
                $insert = trim($insert, ',');
                $req = Yii::app()->db->createCommand(
                        "INSERT INTO {{customer_group}} "
                        . " (`customer_ID`,`group_ID`) VALUES " . $insert
                );
                $req->query();
            }
        }

        public static function deleteItem($customer_ID, $groups)
        {

            if (!$customer_ID || !$groups || !is_array($groups))
            {
                return;
            }
            $IN = trim(implode(',', $groups), ',');
            $req = Yii::app()->db->createCommand(
                    "DELETE FROM {{customer_group}} "
                    . " WHERE group_ID IN ({$IN}) and customer_ID={$customer_ID} "
            );
            $req->query();
        }

        public static function customerGroups($customer_ID)
        {
            if (!$customer_ID)
            {
                return;
            }
            $req = Yii::app()->db->createCommand(
                    "SELECT group_ID as id "
                    . "FROM {{customer_group}} "
                    . " WHERE customer_ID={$customer_ID}"
            );

            return $req->queryColumn();
        }

    }