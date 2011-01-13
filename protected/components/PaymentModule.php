<?php

    class PaymentModule extends CWebModule
    {

        public $defaultController = 'site';

        public function init()
        {

        }

        public function beforeControllerAction($controller, $action)
        {
            if (parent::beforeControllerAction($controller, $action))
            {
                // this method is called before any module controller action is performed
                // you may place customized code here
                return true;
            }
            else
                return false;
        }

        public function validateOrder($cart_ID, $order_status, $amountPaid, $paymentMethod = 'Unknown', $message = NULL, $extraVars = array(), $currency_special = NULL, $dont_touch_amount = false)
        {
            $cart = cart::model()->findByPk(intval($cart_cart));
            if ($cart AND !$cart->orderExists())
            {
                $order = new order_entity();
                $customer = customer_entity::model()->findByPk($cart->cart_customer_ID);
                $currency = currency::model()->findByPK($cart->cart_currency_ID);
                $order->order_carrier_ID = intval($cart->cart_carrier_ID);
                $order->order_address_ID = intval($cart->cart_address_ID);
                $order->order_cart_ID = intval($cart->cart_ID);
                $order->order_currency_ID = intval($cart->cart_currency_ID);
                $order->order_customer_ID = intval($cart->cart_customer_ID);
                $order->order_salt = $customer->customer_salt;
                $order->order_payment_method = $paymentMethod;
                $amountPaid = !$dont_touch_amount ? round(floatval($amountPaid), 2) : $amountPaid;
                $order->order_total_paid = $amountPaid;
                $order->order_total_discount = product_entity::decoratePrice($cart->getOrderTotal(2));
                $order->order_total_products = product_entity::decoratePrice($cart->getOrderTotal(1));
                $order->order_total_shipping = product_entity::decoratePrice($cart->getOrderShippingCost());
                $order->order_grand = product_entity::decoratePrice($cart->getOrderTotal());
                $order->order_delivery_ID = 0;
                $order->order_payment_date = date('Y-m-d H:i:s');
                $order->order_delivery_date = '0000-00-00 00:00:00';
                if ($order->order_total_paid < $order->order_grand)
                    $order_status = order_entity::PaymentError;
                $order->order_status = $order_status;
                $res = $order->save();

                if ($res AND $order->order_ID)
                {
                    //order detail
                    foreach ($cart->products as $product)
                    {
                        $quantity = $cart->containProduct($row->product_ID);
                        $orderDetail = new order_detail();
                        $orderDetail->detail_order_ID = $order->order_ID;
                        $orderDetail->detail_product_ID = $product->product_ID;
                        $orderDetail->detail_product_name = $product->product_name;
                        if ($quantity['quantity'] > 1)
                        {
                            $discount_ID = discount_quantity::validateQuantityDiscount($product->product_ID, $quantity['quantity']);
                            if ($discount_ID)
                            {

                                $discountQuantity = discount_quantity::model()->findByPk($discount_ID);
                                $orderDetail->detail_quantity_discount = $currency->convert($product->product_price - $discountQuantity->applyRule($product->product_price));
                                $orderDetail->detail_quantity_discount_applied = 1;
                                $orderDetail->detail_reducetion_percent = 0;
                                $orderDetail->detail_reducetion_amount = 0;
                                $orderDetail->detail_product_price = $currency->convert($product->product_price - $orderDetail->detail_quantity_discount);
                            }
                        }
                        else
                        {
                            if ($product->isReduction())
                            {
                                if ($product->product_reducetion_percent)
                                {
                                    $orderDetail->detail_reducetion_percent = $currency->convert(floatval($product->product_price) * floatval($product->product_reducetion_percent / 100), 2);
                                    $orderDetail->detail_reducetion_amount = 0;
                                    $orderDetail->detail_quantity_discount = 0;
                                    $orderDetail->detail_quantity_discount_applied = 2;
                                    $orderDetail->detail_product_price = $currency->convert($product->product_price - $orderDetail->detail_reducetion_percent);
                                }
                                else
                                {
                                    $orderDetail->detail_reducetion_amount = $currency->convert($product->product_reducetion_amount);
                                    $orderDetail->detail_reducetion_percent = 0;
                                    $orderDetail->detail_quantity_discount = 0;
                                    $orderDetail->detail_quantity_discount_applied = 2;
                                    $orderDetail->detail_product_price = $currency->convert($product->product_price - $orderDetail->detail_reducetion_amount);
                                }
                            }
                            else
                            {
                                $orderDetail->detail_reducetion_amount = 0;
                                $orderDetail->detail_reducetion_percent = 0;
                                $orderDetail->detail_quantity_discount = 0;
                                $orderDetail->detail_quantity_discount_applied = 2;
                                $orderDetail->detail_product_price = $currency->convert($product->product_price);
                            }
                        }
                        $orderDetail->order_weight = floatval($product->product_weight);
                        $orderDetail->save();
                        //update product info
                        if ($order->order_status != order_entity::PaymentError AND $order->order_status != order_entity::Canceled)
                        {
                            $product->product_quantity-=$quantity['quantity'];
                            $product->save();
                        }
                    }

                    //order_discount
                    if (sizeof($discounts = cart_discount::items($cart->cart_ID)) >= 1)
                    {
                        foreach ($discounts as $discount)
                        {
                            $orderDiscount = new order_discount();
                            $orderDiscount->order_ID = $order->order_ID;
                            $orderDiscount->discount_ID = $discount['discount_ID'];
                            $orderDiscount->discount_name = $discount['discount_name'];
                            if ($discount['discount_type'] == 3)
                            {
                                $orderDiscount->discount_value = 0;
                            }
                            else if ($discount['discount_type'] == 2)
                            {
                                $orderDiscount->discount_value = $currency->convert($discount['discount_value']);
                            }
                            else if ($discounts['discount_type'] == 1)
                            {
                                $orderDiscount->discount_value = $currency->convert($order->order_total_products * ( $discount['discount_value'] / 100));
                            }
                        }
                    }

                    /**
                     * To do list
                     * 1.Email confirm
                     * 2.Product sales
                     * 3.Order message
                     * 4.order History
                     *
                     */
                }
            }
        }

    }

?>