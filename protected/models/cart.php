<?php

    /**
     * This is the model class for table "{{cart}}".
     *
     * The followings are the available columns in table '{{cart}}':
     * @property integer $cart_ID
     * @property integer $cart_carrier_ID
     * @property integer $cart_address_ID
     * @property integer $cart_currency_ID
     * @property integer $cart_customer_ID
     * @property integer $cart_guest_ID
     * @property string $cart_create
     * @property string $cart_update
     */
    class cart extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return cart the static model class
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
            return '{{cart}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('cart_carrier_ID, cart_address_ID, cart_currency_ID, cart_customer_ID, cart_guest_ID, cart_create, cart_update', 'required'),
                array('cart_carrier_ID, cart_address_ID, cart_currency_ID, cart_customer_ID, cart_guest_ID', 'numerical', 'integerOnly' => true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('cart_ID, cart_carrier_ID, cart_address_ID, cart_currency_ID, cart_customer_ID, cart_guest_ID, cart_create, cart_update', 'safe', 'on' => 'search'),
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
                'products' => array(self::MANY_MANY, 'product_entity', 'tm_cart_product(cart_ID,product_ID)')
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'cart_ID' => 'Cart',
                'cart_carrier_ID' => 'Cart Carrier',
                'cart_address_ID' => 'Cart Address',
                'cart_currency_ID' => 'Cart Currency',
                'cart_customer_ID' => 'Cart Customer',
                'cart_guest_ID' => 'Cart Guest',
                'cart_create' => 'Cart Create',
                'cart_update' => 'Cart Update',
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

            $criteria->compare('cart_ID', $this->cart_ID);

            $criteria->compare('cart_carrier_ID', $this->cart_carrier_ID);

            $criteria->compare('cart_address_ID', $this->cart_address_ID);

            $criteria->compare('cart_currency_ID', $this->cart_currency_ID);

            $criteria->compare('cart_customer_ID', $this->cart_customer_ID);

            $criteria->compare('cart_guest_ID', $this->cart_guest_ID);

            $criteria->compare('cart_create', $this->cart_create, true);

            $criteria->compare('cart_update', $this->cart_update, true);

            return new CActiveDataProvider('cart', array(
                'criteria' => $criteria,
            ));
        }

        public function updateQty($qty, $product_ID, $operator='up')
        {
            if (intval($qty) <= 0)
                return $this->deleteProduct(intval($product_ID));
            else
            {
                $result = $this->containProduct($product_ID);

                //if has contain product,update qty
                if ($result)
                {
                    if ($operator == 'up')
                    {
                        $product = product_entity::model()->findByPk($product_ID);
                        $newQty = $result['quantity'] + intval($qty);
                        if ($newQty > $product->product_quantity || $product->product_quantity < 5)
                        {
                            return FALSE;
                        }
                        $updateCommand = '`Quantity`+' . intval($qty);
                    }
                    else if ($operator == 'down')
                    {
                        $newQty = $result['quantity'] - intval($qty);
                        $updateCommand = '`Quantity`-' . intval($qty);
                    }
                    else
                    {
                        return FALSE;
                    }
                    if ($newQty <= 0)
                    {
                        return $this->deleteProduct(intval($product_ID));
                    }
                    else
                    {
                        $req = Yii::app()->db->createCommand(
                                "Update {{cart_product}} SET Quantity={$updateCommand}"
                                . " WHERE cart_ID={$this->cart_ID} AND product_ID={$product_ID}"
                        );
                        $req->execute();
                    }
                }
                else
                {
                    //add new product to cart
                    $product = product_entity::model()->findByPk($product_ID);
                    if ($qty > $product->product_quantity || $product->product_quantity < 5)
                    {
                        return FALSE;
                    }
                    $req = Yii::app()->db->createCommand(
                            "INSERT INTO {{cart_product}} (`cart_ID`,`product_ID`,`quantity`)"
                            . " VALUES ('{$this->cart_ID}','{$product->product_ID}','{$qty}')"
                    );
                    $req->execute();
                }
                $this->cart_update = date('Y-m-d H:i:s');
                return $this->update();
            }
        }

        public function deleteProduct($product_ID)
        {
            if (!$product_ID)
            {
                return false;
            }
            $req = Yii::app()->db->createCommand(
                    "DELETE FROM {{cart_product}} "
                    . " WHERE cart_ID='{$this->cart_ID}' AND product_ID='{$product_ID}'"
            );
            return $req->execute();
        }

        public function containProduct($product_ID)
        {
            if (!$product_ID)
            {
                return false;
            }
            $req = Yii::app()->db->createCommand(
                    "SELECT quantity from {{cart_product}} "
                    . " WHERE cart_ID='{$this->cart_ID}' AND product_ID='{$product_ID}'"
            );
            return $req->queryRow();
        }

        public static function AddCart($guest_ID, $currency_ID)
        {
            if ($guest_ID && $currency_ID)
            {
                $now = date('Y-m-d H:i:s');
                $req = Yii::app()->db->createCommand(
                        "INSERT INTO {{cart}} "
                        . " (`cart_carrier_ID`,`cart_address_ID`,`cart_currency_ID`,`cart_customer_ID`,`cart_guest_ID`,`cart_update`) "
                        . " VALUES ('0','0','{$currency_ID}','0','{$guest_ID}','{$now}')"
                );
                $req->execute();
                return Yii::app()->db->commandBuilder->getLastInsertID('{{cart}}');
            }
            else
            {
                return 0;
            }
        }

        public function nbDiscounts($discount_ID)
        {
            if (!$discount_ID)
            {
                return 0;
            }
            $req = Yii::app()->db->createCommand(
                    'SELECT count(m1.cart_ID) FROM {{cart_discount}} as m1 '
                    . "WHERE m1.cart_ID={$this->cart_ID} AND m1.discount_ID={$discount_ID}"
            );

            $req->queryScalar();
        }

        public function validateDiscount($orderTotal, $discountID, $checkCartDiscount=false)
        {
            $discount = discount_entity::model()->findByPk($discountID);

            if (!$orderTotal > 0)
                return 'cannot add voucher if order is free';
            if (!$discount->discount_active == 1)
                return 'this voucher has already been used or is disabled';
            if (!$discount->discount_quantity)
                return 'this voucher has expired (usage limit attained)';
            if ($checkCartDiscount
                AND ($this->nbDiscounts($discount->discount_ID) >= $discount->discount_quantity_per_user
                OR (order_discount::nbDiscountCustomer(Yii::app()->user->getId(), $discount->discount_ID) + $this->nbDiscounts($discount->discount_ID) >= $discount->discount_quantity_per_user)))
                return 'you cannot use this voucher anymore (usage limit attained)';
            if (strtotime($discount->discount_from) > time())
                return 'this voucher is not yet valid';
            if (strtotime($discount->discount_to) < time())
                return 'this voucher has expired';
            if (sizeof($discounts = cart_discount::items($this->cart_ID)) >= 1 AND $checkCartDiscount)
            {
                if (!$discount->discount_cumulable == 1)
                    return 'this voucher isn\'t cumulative with other current discounts';
                foreach ($discounts as $row)
                    if (!$row['discount_cumulable'] == 1)
                        return 'previous voucher added isn\'t cumulative with other discounts';
            }
            if (is_array($discounts) AND array_key_exists($discount->discount_ID, $discounts))
                return 'this voucher is already in your cart';
            if ($discount->discount_customer_ID AND $discount->discount_customer_ID != Yii::app()->user->getId())
            {
                if (!Yii::app()->user->isGuest)
                    return 'you cannot use this voucher-try to log in if you own it';
                return 'you cannot use this voucher';
            }

            $onlyProductWithDiscount = true;
            if (!$discount->discount_cumulable_reduction == 1)
            {
                foreach ($this->products as $product)
                    if (!intval($product['product_reducetion_price']) AND !intval($product['product_reducetion_percent']))
                        $onlyProductWithDiscount = false;
            }
            if (!$discount->discount_cumulable_reduction == 1 AND $onlyProductWithDiscount)
                return 'this voucher isn\'t cumulative on products with reduction';

            $categories = discount_category::items($discount->discount_ID);
            $returnErrorNoProductCategory = true;
            foreach ($this->products AS $product)
            {
                if (count($categories))
                    if ($product->productInCategories($categories))
                    {
                        $returnErrorNoProductCategory = false;
                    }
            }
            if ($returnErrorNoProductCategory)
                return 'this discount isn\'t applicable to that product category';
            $minimal = product_entity::decoratePrice($discount->discount_minimal);
            if ($orderTotal < $minimal)
                return 'the total amount of your order isn\'t high enough or this voucher cannot be used with those products';
            return false;
        }

        public function checkDiscounts($orderTotal)
        {
            if (!$orderTotal > 0)
            {
                cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID));
                return;
            }

            if (sizeof($discounts = cart_discount::items($this->cart_ID)) >= 1)
            {
                foreach ($discounts as $discount)
                {
                    $minimal = product_entity::decoratePrice($discount['discount_minmal']);
                    if ($orderTotal < $minimal)
                    {
                        cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID, 'discount_ID' => $discount['discount_ID']));
                        break;
                    }
                    if (!$discount['discount_active'] == 1 OR !$discount['discount_quantity'])
                    {
                        cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID, 'discount_ID' => $discount['discount_ID']));
                        break;
                    }
                    if (strtotime($discount['discount_from']) > time() OR strtotime($discount['discount_to']) < time())
                    {
                        cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID, 'discount_ID' => $discount['discount_ID']));
                        break;
                    }
                    if ($this->nbDiscounts($discount['discount_ID']) >= $discount['discount_quantity_per_user']
                        OR (order_discount::nbDiscountCustomer(Yii::app()->user->getId(), $discount['discount_ID']) + $this->nbDiscounts($discount['discount_ID']) >= $discount['discount_quantity_per_user']))
                    {
                        cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID, 'discount_ID' => $discount['discount_ID']));
                        break;
                    }

                    $onlyProductWithDiscount = true;
                    if (!$discount['discount_cumulable_reduction'] == 1)
                    {
                        foreach ($this->products as $product)
                            if (!intval($product['product_reducetion_price']) AND !intval($product['product_reducetion_percent']))
                            {
                                $onlyProductWithDiscount = false;
                                break;
                            }
                    }
                    if (!$discount['discount_cumulable_reduction'] == 1 AND $onlyProductWithDiscount)
                    {
                        cart_discount::model()->deleteAllByAttributes(array('cart_ID' => $this->cart_ID, 'discount_ID' => $discount['discount_ID']));
                        break;
                    }
                }
            }
            return;
        }

        public function getWeightTotal()
        {
            $req = Yii::app()->db->createCommand(
                    'SELECT sum(m2.product_weight*m1.quantity) FROM {{cart_product}} as m1 '
                    . ' LEFT JOIN {{product_entity}} as m2 ON m1.product_ID=m2.product_ID'
                    . " WHERE m1.cart_ID={$this->cart_ID}"
            );

            return $req->queryScalar();
        }

        public function isFreeshipping()
        {
            $freeshippingPrice = configuration::item('SHIPPING', 'SHIPPING_FREE_PRICE');
            if ($this->getOrderTotal(4) >= $freeshippingPrice)
            {
                return TRUE;
            }
            $req = Yii::app()->db->createCommand(
                    'SELECT m2.discount_ID FROM {{cart_discount}} as m1 '
                    . ' LEFT JOIN {{discount_entity}} as m2 ON m1.discount_ID=m2.discount_ID'
                    . " WHERE m2.discount_type=3 AND m1.cart_ID={$this->cart_ID}"
            );
            if ($req->queryScalar())
                return TRUE;
            return FALSE;
        }

        /**
         * This function returns the total cart amount
         *
         * type = 1 : only products
         * type = 2 : only discounts
         * type = 3 : both
         * type = 4 : both but without shipping
         * type = 5 : only shipping
         *
         *
         * @param integer $type Total type
         * @return float Order total
         */
        public function getOrderTotal($type=3)
        {
            if (!$this->cart_ID)
                return 0;
            $type = intval($type);
            if (!in_array($type, array(1, 2, 3, 4, 5)))
                return 0;
            $shipping_fees = ($type != 4 AND $type != 1) ? $this->getOrderShippingCost(NULL) : 0;
            $orderTotal = 0;
            foreach ($this->products as $product)
            {
                $quantity = $this->containProduct($product->product_ID);
                $price = $product->getInternalPrice(true,$quantity['quantity']);
                $subtotal =$price * $quantity['quantity'];
                $orderTotal+=$subtotal;
            }
            $order_total_products = $orderTotal;
            if ($type==2)
                $orderTotal = 0;
            if ($type != 1)
            {
                if (sizeof($discounts = cart_discount::items($this->cart_ID)) >= 1)
                {
                    foreach ($discounts as $discount)
                    {
                        if ($discount['discount_type'] == 3)
                        {
                            if ($type == 2)
                                $orderTotal-=$shipping_fees;
                            $shipping_fees = 0;
                            break;
                        }
                        else if ($discount['discount_type'] == 2)
                        {
                            $orderTotal-=floatval($discount['discount_value']);
                        }
                        else if ($discounts['discount_type'] == 1)
                        {
                            $orderTotal-=round($order_total_products * (1 - $discount['discount_value'] / 100), 2);
                        }
                    }
                }
            }
            if ($type == 5)
                return $shipping_fees;
            if ($type == 3)
                return round($orderTotal+=$shipping_fees,2);
            if ($orderTotal < 0 AND $type != 2)
                return 0;
            return round(floatval($orderTotal), 2);
        }

        /**
         * Return shipping total
         *
         * @param integer $Carrier_ID Carrier ID (default : current carrier)
         * @return float Shipping total
         */
        public function getOrderShippingCost($carrier_ID=NULL)
        {
            if ($this->isFreeshipping())
            {
                return 0;
            }

            // Get id zone
            if (isset($this->cart_address_ID) AND $this->cart_address_ID)
                $id_zone = address_entity::model()->findByPk($this->cart_address_ID)->getZoneId();
            else
                $id_zone = 1;
            //if no carrier selectd,chosen default one
            if (!$carrier_ID)
                $carrier_ID = $this->cart_carrier_ID;

            if (empty($carrier_ID))
            {
                return 0;
            }
            if (!$carrier = carrier_entity::model()->findByPk($carrier_ID))
            {
                throw new CHttpException(500, 'No Carrier Chosen');
            }
            if($carrier->carrier_shipping_handing!=1)
            {
                return 0;
            }
            if(!$weightID=weight_range::validateCarrier($this->getWeightTotal(),$carrier_ID))
            {
                return 'Out';
            }
            $shippingCost=0;
           if($delivery=delivery::model()->findByAttributes(array('carrier_ID'=>$carrier_ID,'zone_ID'=>$id_zone,'weight_range_ID'=>$weightID)))
           {
               $shippingCost=$delivery->price;
           }

           return $shippingCost;
        }

        public function orderExists()
        {
               $req = Yii::app()->db->createCommand(
                    'SELECT m1.order_ID FROM {{order_entity}} as m1 '
                    . " WHERE  m1.order_cart_ID={$this->cart_ID} limit 1"
            );
            if ($req->queryScalar())
                return TRUE;
            return FALSE;
        }
    }