<?php

    /**
     * This is the model class for table "{{configuration}}".
     *
     * The followings are the available columns in table '{{configuration}}':
     * @property integer $config_ID
     * @property string $config_type
     * @property string $config_name
     * @property string $config_value
     * @property string $config_create
     * @property string $config_update
     */
    class configuration extends CActiveRecord
    {

        private static $_items = array();

        /**
         * Returns the static model of the specified AR class.
         * @return configuration the static model class
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
            return '{{configuration}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('config_type, config_name, config_value', 'required'),
                array('config_type', 'length', 'max' => 128),
                array('config_name', 'length', 'max' => 32),
                array('config_value', 'length', 'max' => 255),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('config_ID, config_type, config_name, config_value, config_create, config_update', 'safe', 'on' => 'search'),
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
                'config_ID' => 'Config',
                'config_type' => 'Config Type',
                'config_name' => 'Config Name',
                'config_value' => 'Config Value',
                'config_create' => 'Config Create',
                'config_update' => 'Config Update',
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

            $criteria->compare('config_ID', $this->config_ID);

            $criteria->compare('config_type', $this->config_type, true);

            $criteria->compare('config_name', $this->config_name, true);

            $criteria->compare('config_value', $this->config_value, true);

            $criteria->compare('config_create', $this->config_create, true);

            $criteria->compare('config_update', $this->config_update, true);

            return new CActiveDataProvider('configuration', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            $this->config_update = date('Y-m-d H:i:s');
            return true;
        }

        public static function items($type)
        {
            if (!isset(self::$_items[$type]))
                self::loadItems($type);
            return self::$_items[$type];
        }

        public static function item($type, $name)
        {
            if (!isset(self::$_items[$type]))
                self::loadItems($type);
            return isset(self::$_items[$type][$name]) ? self::$_items[$type][$name] : false;
        }

        private static function loadItems($type)
        {
            self::$_items[$type] = array();
            $models = self::model()->findAll(array(
                    'condition' => 'config_type=:type',
                    'params' => array(':type' => $type),
                ));
            foreach ($models as $model)
                self::$_items[$type][$model->config_name] = $model->config_value;
        }

        public static function updateItems($config)
        {
            if (!$config || !is_array($config))
            {
                return false;
            }
            foreach ($config as $key => $value)
            {
                $temp = explode('-', $key);
                $type = $temp[0];
                $name = $temp[1];
             
            
                $model = self::model()->findByAttributes(array('config_type' => $type, 'config_name' => $name));

                if ($model)
                {
                    $model->config_value = $value;
                    $model->save();
                }
             
              
            }
            return true;
        }

    }