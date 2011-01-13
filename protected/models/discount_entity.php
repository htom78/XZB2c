<?php

    /**
     * This is the model class for table "{{discount_entity}}".
     *
     * The followings are the available columns in table '{{discount_entity}}':
     * @property integer $discount_ID
     * @property integer $discount_type
     * @property integer $discount_customer_ID
     * @property string $discount_name
     * @property string $discount_description
     * @property string $discount_value
     * @property integer $discount_quantity
     * @property integer $discount_quantity_per_user
     * @property integer $discount_cumulable
     * @property integer $discount_cumulable_reduction
     * @property integer $discount_active
     * @property string $discount_minimal
     * @property string $discount_from
     * @property string $discount_to
     */
    class discount_entity extends CActiveRecord
    {

        public $discount_customer_email;

        /**
         * Returns the static model of the specified AR class.
         * @return discount_entity the static model class
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
            return '{{discount_entity}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('discount_type, discount_name, discount_value, discount_quantity, discount_quantity_per_user, discount_active, discount_from, discount_to', 'required'),
                array('discount_type, discount_customer_ID, discount_quantity, discount_quantity_per_user, discount_cumulable, discount_cumulable_reduction, discount_active', 'numerical', 'integerOnly' => true),
                array('discount_name', 'length', 'max' => 128),
                array('discount_name', 'unique'),
                array('discount_description', 'length', 'max' => 512),
                array('discount_value, discount_minimal', 'length', 'max' => 17),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('discount_ID, discount_type, discount_customer_ID, discount_name, discount_description, discount_value, discount_quantity, discount_quantity_per_user, discount_cumulable, discount_cumulable_reduction, discount_active, discount_minimal, discount_from, discount_to', 'safe', 'on' => 'search'),
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
                'discount_ID' => 'Discount',
                'discount_type' => 'Discount Type',
                'discount_customer_ID' => 'Discount Customer',
                'discount_name' => 'Discount Name',
                'discount_description' => 'Discount Description',
                'discount_value' => 'Discount Value',
                'discount_quantity' => 'Discount Quantity',
                'discount_quantity_per_user' => 'Discount Quantity Per User',
                'discount_cumulable' => 'Discount Cumulable',
                'discount_cumulable_reduction' => 'Discount Cumulable Reduction',
                'discount_active' => 'Discount Active',
                'discount_minimal' => 'Discount Minimal',
                'discount_from' => 'Discount From',
                'discount_to' => 'Discount To',
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

            $criteria->compare('discount_ID', $this->discount_ID);

            $criteria->compare('discount_type', $this->discount_type);

            $criteria->compare('discount_customer_ID', $this->discount_customer_ID);

            $criteria->compare('discount_name', $this->discount_name, true);

            $criteria->compare('discount_description', $this->discount_description, true);

            $criteria->compare('discount_value', $this->discount_value, true);

            $criteria->compare('discount_quantity', $this->discount_quantity);

            $criteria->compare('discount_quantity_per_user', $this->discount_quantity_per_user);

            $criteria->compare('discount_cumulable', $this->discount_cumulable);

            $criteria->compare('discount_cumulable_reduction', $this->discount_cumulable_reduction);

            $criteria->compare('discount_active', $this->discount_active);

            $criteria->compare('discount_minimal', $this->discount_minimal, true);

            $criteria->compare('discount_from', $this->discount_from, true);

            $criteria->compare('discount_to', $this->discount_to, true);

            return new CActiveDataProvider('discount_entity', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeDelete()
        {
            discount_category::deleteItem($this->discount_ID, discount_category::items($this->discount_ID));
            if ($this->hasEventHandler('onBeforeDelete'))
            {
                $event = new CModelEvent($this);
                $this->onBeforeDelete($event);
                return $event->isValid;
            }
            else
                return true;
        }

    }