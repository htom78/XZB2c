<?php

    /**
     * This is the model class for table "{{currency}}".
     *
     * The followings are the available columns in table '{{currency}}':
     * @property integer $currency_ID
     * @property string $name
     * @property string $iso_code
     * @property string $sign
     * @property integer $blank
     * @property integer $format
     * @property integer $decimals
     * @property string $conversion_rate
     * @property integer $deleted
     */
    class currency extends CActiveRecord
    {

        private static $_items = array();

        /**
         * Returns the static model of the specified AR class.
         * @return currency the static model class
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
            return '{{currency}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('name, sign, conversion_rate', 'required'),
                array('blank, format, decimals, deleted', 'numerical', 'integerOnly' => true),
                array('name', 'length', 'max' => 32),
                array('iso_code', 'length', 'max' => 3),
                array('sign', 'length', 'max' => 8),
                array('conversion_rate', 'length', 'max' => 13),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('currency_ID, name, iso_code, sign, blank, format, decimals, conversion_rate, deleted', 'safe', 'on' => 'search'),
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
                'currency_ID' => 'Currency',
                'name' => 'Name',
                'iso_code' => 'Iso Code',
                'sign' => 'Sign',
                'blank' => 'Blank',
                'format' => 'Format',
                'decimals' => 'Decimals',
                'conversion_rate' => 'Conversion Rate',
                'deleted' => 'Deleted',
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
                    'condition' => 'deleted=2',
                ));

            $criteria->compare('currency_ID', $this->currency_ID);

            $criteria->compare('name', $this->name, true);

            $criteria->compare('iso_code', $this->iso_code, true);

            $criteria->compare('sign', $this->sign, true);

            $criteria->compare('blank', $this->blank);

            $criteria->compare('format', $this->format);

            $criteria->compare('decimals', $this->decimals);

            $criteria->compare('conversion_rate', $this->conversion_rate, true);

            $criteria->compare('deleted', $this->deleted);

            return new CActiveDataProvider('currency', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            if ($this->isNewRecord)
            {
                $this->deleted = 2;
                $this->blank = 0;
                $this->format = 1;
                $this->decimals = 1;
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
                    $this->deleted = 1;
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

        public function refreshCurrency($data, $isoCodeSource, $defaultCurrency)
        {
            if ($this->iso_code != $isoCodeSource)
            {
                /* Seeking for rate in feed */
                foreach ($data->currency AS $obj)
                    if ($this->iso_code == strval($obj['iso_code']))
                        $this->conversion_rate = round(floatval($obj['rate']) / $defaultCurrency->conversion_rate, 6);
            }
            else
            {
                /* If currency is like isoCodeSource, setting it to default conversion rate */
                $this->conversion_rate = round(1 / floatval($defaultCurrency->conversion_rate), 6);
            }
            $this->update();
        }

        public function convert($price)
        {
            if($this->iso_code=='USD')
                return $price;
            return round($this->conversion_rate*$price,2);
        }

        static public function refreshDefCurrency($data, $isoCodeSource, $defaultCurrency)
        {
            /* Change defaultCurrency rate if not as currency of feed source */
            if ($defaultCurrency->iso_code != $isoCodeSource)
                foreach ($data->currency AS $obj)
                    if ($defaultCurrency->iso_code == strval($obj['iso_code']))
                        $defaultCurrency->conversion_rate = round(floatval($obj['rate']), 6);
            return $defaultCurrency;
        }

        static public function refreshCurrencies()
        {
            if (!$feed = @simplexml_load_file('http://www.prestashop.com/xml/currencies.xml'))
                return false;
            if (!$defaultCurrency = self::model()->findByAttributes(array('iso_code' => "USD")))
            {
                return false;
            }
            $isoCodeSource = strval($feed->source['iso_code']);
            $currencies = self::model()->findAll(array(
                    'condition' => 'deleted=2',
                ));
            $defaultCurrency = self::refreshDefCurrency($feed->list, $isoCodeSource, $defaultCurrency);
            foreach ($currencies as $currency)
                if ($currency->iso_code != $defaultCurrency->iso_code)
                    $currency->refreshCurrency($feed->list, $isoCodeSource, $defaultCurrency);
        }

        public static function items()
        {

            if (!isset(self::$_items) || !self::$_items)
                self::loadItems();
            return self::$_items;
        }

        public static function item($ID)
        {

            if (!isset(self::$_items) || !self::$_items)
                self::loadItems();
            return isset(self::$_items[$ID]) ? self::$_items[$ID] : false;
        }

        private static function loadItems()
        {
            self::$_items = array();
            $models = self::model()->findAll(array(
                    'condition' => 'deleted=2',
                ));
            foreach ($models as $model)
                self::$_items[$model->name] = $model->conversion_rate;
        }

        public static function getCurrencies()
        {
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.currency_ID as id,concat(m1.name,' ',m1.sign) as name FROM {{currency}} as m1 "
                    . " WHERE m1.deleted=2"
            );
            $res = $req->queryAll();
            $out = array();
            if ($res)
            {
                foreach ($res as $row)
                {
                    $out[$row['id']]=$row['name'];
                }
            }
            return $out;
        }

        public static function getSign()
        {
            if($currency=self::model()->findByPk(Yii::app()->user->getState('currency_ID')));
            {
                return $currency->sign;
            }
            return '$';
        }
    }