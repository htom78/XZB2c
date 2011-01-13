<?php

    class SiteController extends Controller
    {

        public function actionIndex()
        {
            $cart = cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
            $currency = currency::model()->findByPk($cart->cart_currency_ID);
            $address = address_entity::model()->findByPk($cart->cart_address_ID);
            $country = country::model()->findByPk($address->address_country_ID);
            $business = 'seller_1287970770_biz@gmail.com';
            if ($country->contain_states == 1)
            {
                $state = state::item($address->address_state_ID);
            }
            $customer = customer_entity::model()->findByPk(Yii::app()->user->getId());
            $data = array(
                'paypal_url' => $this->module->getPaypalUrl(),
                'address' => $address,
                'country' => $country,
                'state' => $state,
                'amount' => floatval($cart->getOrderTotal(4)),
                'customer' => $customer,
                'total' => product_entity::decoratePrice($cart->getOrderTotal(3)),
                'shipping' => product_entity::decoratePrice($cart->getOrderTotal(5)),
                'discount' => product_entity::decoratePrice($cart->getOrderTotal(2)),
                'business' => $business,
                'currency' => $currency,
                'cart' => $cart,
                'products' => $cart->products,
                'url' => 'http://www.gift.com'
            );
            $this->render('index', $data);
        }

        public function validation()
        {
            // Fill params
            $params = 'cmd=_notify-validate';
            foreach ($_POST AS $key => $value)
                $params .= '&' . $key . '=' . urlencode(stripslashes($value));

            // PayPal Server
            $paypalServer = 'www.sandbox.paypal.com';

           // Getting PayPal data...
            if (function_exists('curl_exec'))
            {
                // curl ready
                $ch = curl_init('https://' . $paypalServer . '/cgi-bin/webscr');

                // If the above fails, then try the url with a trailing slash (fixes problems on some servers)
                if (!$ch)
                    $ch = curl_init('https://' . $paypalServer . '/cgi-bin/webscr/');

                if (!$ch)
                    $errors .= 'connect' . ' ' . 'curlMethodFailed';
                else
                {
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $result = curl_exec($ch);

                    if ($result != 'VERIFIED')
                        $errors .= 'connect' . ' ' . ' cURL error:' . curl_error($ch);
                    curl_close($ch);
                }
            }
            elseif (($fp = @fsockopen('ssl://' . $paypalServer, 443, $errno, $errstr, 30)) || ($fp = @fsockopen($paypalServer, 80, $errno, $errstr, 30)))
            {
                // fsockopen ready
                $header = 'POST /cgi-bin/webscr HTTP/1.0' . "\r\n" .
                    'Host: ' . $paypalServer . "\r\n" .
                    'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
                    'Content-Length: ' . strlen($params) . "\r\n" .
                    'Connection: close' . "\r\n\r\n";
                fputs($fp, $header . $params);

                $read = '';
                while (!feof($fp))
                {
                    $reading = trim(fgets($fp, 1024));
                    $read .= $reading;
                    if (($reading == 'VERIFIED') || ($reading == 'INVALID'))
                    {
                        $result = $reading;
                        break;
                    }
                }
                if ($result != 'VERIFIED')
                    $errors .= 'socketmethod' . $result;
                fclose($fp);
            }
            else
                $errors = 'connect nomethod';

// Printing errors...
            if ($result == 'VERIFIED')
            {
                if (!isset($_POST['mc_gross']))
                    $errors .= 'mc_gross<br />';
                if (!isset($_POST['payment_status']))
                    $errors .= 'payment_status<br />';
                elseif ($_POST['payment_status'] != 'Completed')
                    $errors .= 'payment' . $_POST['payment_status'] . '<br />';
                if (!isset($_POST['custom']))
                    $errors .= 'custom<br />';
                if (!isset($_POST['txn_id']))
                    $errors .= 'txn_id<br />';
                if (!isset($_POST['mc_currency']))
                    $errors .= 'mc_currency<br />';
                if (empty($errors)){
                    $cart = new cart(intval($_POST['custom']));
                    if (!$cart->cart_ID)
                        $errors = 'cart<br />';
                  else
			      $this->module->validateOrder($_POST['custom'], order_entity::PaymentAccepted, floatval($_POST['mc_gross']), 'Paypal', 'transaction'.$_POST['txn_id']);
                }
            } else{
                $errors .= 'verified';
            }

            if (!empty($errors) AND isset($_POST['custom']))
            {
                if ($_POST['payment_status'] == 'Pending')
                    $this->module->validateOrder($_POST['custom'], order_entity::PaymentError, floatval($_POST['mc_gross']), 'Paypal', 'transaction'.$_POST['txn_id'].$errors);
                else
                     $this->module->validateOrder($_POST['custom'], order_entity::AwaitingPayment,0, $errors);
            }
        }

    }