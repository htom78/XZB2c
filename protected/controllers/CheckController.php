<?php

    class CheckController extends Controller
    {

        public $layout = 'column1';
        public $step = 1;

        public function filters()
        {
            return array(
                'accessControl',
            );
        }

        public function accessRules()
        {
            return array(
                array('allow',
                    'actions' => array('index', 'shipping', 'payment'),
                    'users' => array('@'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }

        public function actionIndex()
        {
            $address = address_entity::items(Yii::app()->user->getId());
            $cart = cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
            if ((!isset($cart->cart_address_ID) OR empty($cart->cart_address_ID)) AND sizeof($address))
            {
                foreach ($address as $key => $row)
                {
                    $addressID = $key;
                    break;
                }
                $cart->cart_address_ID = intval($key);
                $cart->save();
            }
            $shipping;
            if (isset($cart->cart_address_ID))
            {
                $shipping = address_entity::model()->findByPk($cart->cart_address_ID);
            }

            $this->render('address', array('address' => $address, 'cart' => $cart, 'shipping' => $shipping));
        }

        public function actionShipping()
        {
            $this->step = 2;
            $cart = cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));

            if($_POST['carrier'] && !empty($_POST['carrier']))
            {
                if($model=carrier_entity::model()->findByPk($_POST['carrier']))
                {
                    $cart->cart_carrier_ID=intval($_POST['carrier']);
                    $cart->save();
                    $this->redirect(array('payment'));
                    exit();
                }
            }

            if ((!isset($cart->cart_address_ID) OR empty($cart->cart_address_ID)))
            {
                $this->redirect(array('index'));
            }
            $address = address_entity::model()->findByPk($cart->cart_address_ID);
            $zoneID = $address->getZoneId();
            $carrier = carrier_entity::getByZone($zoneID);
            foreach ($carrier as $key => $row)
            {

                if (!$weightID = weight_range::validateCarrier($cart->getWeightTotal(), $row['carrier_ID']))
                {
                    unset($carrier[$key]);
                    continue;
                }

                $carrier[$key]['price'] = $cart->getOrderShippingCost($row['carrier_ID']);

                $carrier[$key]['selected'] = false;
                if ($cart->cart_carrier_ID == $row['carrier_ID'])
                {
                    $carrier[$key]['selected'] = true;
                }
            }
            $this->render('shipping', array('carrier' => $carrier));
        }

        public function actionPayment()
        {
           $cart = cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
           if(!$cart->cart_address_ID OR !$cart->cart_carrier_ID)
           {
               $this->redirect(array('index'));
               exit();
           }
           if(!$address=address_entity::model()->findByPk($cart->cart_address_ID))
           {
               $this->redirect(array('index'));
               exit();
           }
       
           $grandTotal=  product_entity::decoratePrice($cart->getOrderTotal(),true);
           $this->render('payment',array('grandTotal'=>$grandTotal));
        }

    }

?>
