<?php

    /**
     * This is the model class for table "{{product_entity}}".
     *
     * The followings are the available columns in table '{{product_entity}}':
     * @property integer $product_ID
     * @property string $product_name
     * @property string $product_SEF
     * @property double $product_weight
     * @property integer $product_def_category_ID
     * @property string $product_description
     * @property string $product_short_description
     * @property string $product_SKU
     * @property integer $product_SEO_ID
     * @property integer $product_status
     * @property integer $product_quantity
     * @property string $product_price
     * @property string $product_wholesale_price
     * @property string $product_reducetion_price
     * @property double $product_reducetion_percent
     * @property string $product_reducetion_from
     * @property string $product_reducetion_to
     * @property integer $product_active
     * @property string $product_create
     * @property string $product_update
     */
    class product_entity extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return product_entity the static model class
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
            return '{{product_entity}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('product_name, product_SEF, product_def_category_ID, product_description,  product_SKU, product_SEO_ID, product_status, product_quantity, product_price,product_active,product_update', 'required'),
                array('product_def_category_ID, product_SEO_ID, product_status, product_quantity, product_active', 'numerical', 'integerOnly' => true),
                array('product_weight, product_reducetion_percent', 'numerical'),
                array('product_name', 'length', 'max' => 256),
                array('product_SEF, product_short_description', 'length', 'max' => 512),
                array('product_SKU', 'length', 'max' => 9),
                array('product_SKU', 'unique'),
                array('product_price, product_wholesale_price', 'length', 'max' => 20),
                array('product_reducetion_price', 'length', 'max' => 17),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('product_ID, product_name, product_SEF, product_weight, product_def_category_ID, product_description, product_short_description, product_SKU, product_SEO_ID, product_status, product_quantity, product_price, product_wholesale_price, product_reducetion_price, product_reducetion_percent, product_reducetion_from, product_reducetion_to, product_active, product_create, product_update', 'safe', 'on' => 'search'),
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
                'defCategory' => array(self::BELONGS_TO, 'category_entity', 'product_def_category_ID'),
                'seo' => array(self::BELONGS_TO, 'seo', 'product_SEO_ID'),
                'categories' => array(self::MANY_MANY, 'category_entity', '{{category_product}}(product_ID,category_ID)'),
                'images' => array(self::HAS_MANY, 'image_entity', 'image_product_ID'),
                'cover' => array(self::HAS_ONE, 'image_entity', 'image_product_ID', 'condition' => 'image_cover=1'),
                'maxWholesale' => array(self::HAS_ONE, 'discount_quantity', 'product_ID', 'order' => 'quantity DESC'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'product_ID' => 'Product',
                'product_name' => 'Product Name',
                'product_SEF' => 'Product Sef',
                'product_weight' => 'Product Weight',
                'product_def_category_ID' => 'Product Def Category',
                'product_description' => 'Product Description',
                'product_short_description' => 'Product Short Description',
                'product_SKU' => 'Product Sku',
                'product_SEO_ID' => 'Product Seo',
                'product_status' => 'Product Status',
                'product_quantity' => 'Product Quantity',
                'product_price' => 'Product Price',
                'product_wholesale_price' => 'Product Wholesale Price',
                'product_reducetion_price' => 'Product Reducetion Price',
                'product_reducetion_percent' => 'Product Reducetion Percent',
                'product_reducetion_from' => 'Product Reducetion From',
                'product_reducetion_to' => 'Product Reducetion To',
                'product_active' => 'Product Active',
                'product_create' => 'Product Create',
                'product_update' => 'Product Update',
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

            $criteria->compare('product_ID', $this->product_ID);

            $criteria->compare('product_name', $this->product_name, true);

            $criteria->compare('product_SEF', $this->product_SEF, true);

            $criteria->compare('product_def_category_ID', $this->product_def_category_ID);

            $criteria->compare('product_description', $this->product_description, true);

            $criteria->compare('product_short_description', $this->product_short_description, true);

            $criteria->compare('product_SKU', $this->product_SKU, true);

            $criteria->compare('product_SEO_ID', $this->product_SEO_ID);

            $criteria->compare('product_active', $this->product_active);


            return new CActiveDataProvider('product_entity', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            if (is_array($this->product_status))
            {
                foreach ($this->product_status as $row)
                {
                    $res+=$row;
                }
                $this->product_status = $res;
            }

            $this->product_update = date('Y-m-d H:i:s');
            return true;
        }

        protected function beforeDelete()
        {
            $this->seo->delete();
            category_product::model()->deleteAllByAttributes(array('product_ID' => $this->product_ID));
            if ($this->hasEventHandler('onBeforeDelete'))
            {
                $event = new CModelEvent($this);
                $this->onBeforeDelete($event);
                return $event->isValid;
            }
            else
                return true;
        }

        public static function resovelProductStatus($status)
        {
            if ($status == null)
            {
                return;
            }
            $res = array();
            if ($status == 0)
            {
                return $res;
            }

            for ($i = 1; $i < 9; $i*=2)
            {
                if ($status & $i)
                {
                    $res[] = $i;
                }
            }

            return $res;
        }

        public function scopes()
        {
            return array(
                'feature' => array(
                    'condition' => '(product_status &1)=1 AND product_active=1',
                    'order' => ' product_update DESC',
                    'limit' => 8,
                ),
                'promote' => array(
                    'condition' => '(product_status &2)=1 AND product_active=1',
                    'order' => ' product_update DESC',
                    'limit' => 8,
                ),
                'wholesale' => array(
                    'condition' => '(product_status &4)=1 AND product_active=1',
                    'order' => ' product_update DESC',
                    'limit' => 8,
                ),
                'freeshipping' => array(
                    'condition' => '(product_status &8)=1 AND product_active=1',
                    'order' => ' product_update DESC',
                    'limit' => 8,
                ),
                'latest' => array(
                    'condition' => 'product_active=1',
                    'order' => 'product_update DESC',
                    'limit' => 20,
                ),
            );
        }

        public function feature($limit=8)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => '(product_status &1)=1 AND product_active=1',
                'order' => ' product_update DESC',
                'limit' => $limit
            ));
            return $this;
        }

        public function promote($limit=8)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => '(product_status &2)=1 AND product_active=1',
                'order' => ' product_update DESC',
                'limit' => $limit,
            ));
            return $this;
        }

        public function wholesale($limit=8)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => '(product_status &4)=1 AND product_active=1',
                'order' => ' product_update DESC',
                'limit' => $limit,
            ));
            return $this;
        }

        public function freeshipping($limit=8)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => '(product_status &8)=1 AND product_active=1',
                'order' => ' product_update DESC',
                'limit' => $limit,
            ));
            return $this;
        }

        public function latest($limit=20)
        {
            $this->getDbCriteria()->mergeWith(array(
                'order' => 'product_create DESC',
                'limit' => $limit
            ));
            return $this;
        }

        public function getUrl()
        {
            return "/{$this->product_SEF}.html";
        }

        public function getWholesaleMask($type='small')
        {
            $out = '';
            if (($this->product_status & 4) && $this->maxWholesale)
            {
                if ($this->maxWholesale->discount_type_ID == 1)
                {
                    $discount = ceil($this->maxWholesale->value / 10);
                }
                else
                {
                    $discount = ceil((($this->maxWholesale->value) / $this->product_price * 10));
                }

                if ($type == 'small')
                {
                    $out = "<span class='special_pack_small special_pack_small{$discount}'></span>";
                }
                else
                {
                    $out = "<span class='special_pack special_pack{$discount}'></span>";
                }
            }
            return $out;
        }

        public function getShippingMask($type="small")
        {
            $out = '';
            if ($this->product_status & 8)
            {

                if ($type == 'small')
                {
                    $out = "<p class='ac'><img alt='Free DHL' src='/images/freedhl.png'></p>";
                }
                else
                {
                    $out = '<div class="mt_10"><img alt="Free DHL" src="/images/freedhl.png"></div>';
                }
            }
            return $out;
        }

        public function getImageMask()
        {
            $out = null;

            if ($this->isReduction())
            {
                if ($this->product_reducetion_percent)
                {
                    $discount = ceil($this->product_reducetion_percent / 10);
                }
                else
                {
                    $discount = ceil((($this->product_price - $this->product_reducetion_price) / $this->product_price) * 10);
                }

                switch ($discount)
                {
                    case 0:
                        break;
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                        $index = $discount;
                        $out = "<span id='special_{$index}'></span>";
                        break;
                    default:
                }
            }

            return $out;
        }

        public function getInternalPrice($withReduction=true, $quantity=null)
        {
            if ($quantity != null AND is_numeric($quantity))
            {
                $discount_ID = discount_quantity::validateQuantityDiscount($this->product_ID, $quantity);
                if ($discount_ID)
                {
                    //wholesale rule applied,and product reductiion rule ruin
                    $discountQuantity = discount_quantity::model()->findByPk($discount_ID);
                    return $discountQuantity->applyRule($this->product_price);
                }
          
            }
                 if ($withReduction && $this->isReduction())
                {
                    if ($this->product_reducetion_percent)
                    {
                        return round(floatval($this->product_price) * floatval(1 - $this->product_reducetion_percent / 100), 2);
                    }
                    else
                    {
                        $temp = floatval($this->product_price) - floatval($this->product_reducetion_price);
                        if ($temp > 0)
                        {
                            return round($temp, 2);
                        }
                        else
                        {
                            return round(floatval($this->product_price), 2);
                        }
                    }
                }
                else
                {
                    return round(floatval($this->product_price), 2);
                }
         
        }

        public static function decoratePrice($price, $sign=false)
        {
            $id_currency = Yii::app()->user->getState('currency_ID');
            if (!$id_currency)
                return $sign ? '$' . round(floatval($price), 2) : round(floatval($price), 2);
            if (!$currency = currency::model()->findByPk($id_currency))
                return $sign ? '$' . round(floatval($price), 2) : round(floatval($price), 2);
            if ($currency->iso_code == 'USD')
                return $sign ? '$' . round(floatval($price), 2) : round(floatval($price), 2);
            return $sign ? $currency->sign . round(floatval($price) * $currency->conversion_rate, 2) : round(floatval($price) * $currency->conversion_rate, 2);
        }

        public function getPrice($withReduction=true, $quantity=null)
        {
        
                return $this->decoratePrice($this->getInternalPrice($withReduction,$quantity));
          
        }

        public function displayPrice($withReduction=true)
        {
            return self::decoratePrice($this->getInternalPrice($withReduction), true);
        }

        public function isReduction()
        {
            if (($this->product_reducetion_percent || $this->product_reducetion_price))
            {
                $now = date('Y-m-d');
                if ($this->product_reducetion_from < $now && $this->product_reducetion_to > $now)
                {
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function productInCategories($categories)
        {
            if (!$categories OR !is_array($categories))
            {
                return false;
            }

            $IN = implode(',', $categories);

            $req = Yii::app()->db->createCommand(
                    'SELECT count(m1.product_ID) FROM {{category_product}} as m1 '
                    . "WHERE m1.product_ID={$this->product_ID} AND m1.category_ID IN({$IN})"
            );

            return $req->queryScalar();
        }

    }