<p>Please wait, redirecting to Paypal... Thanks.<br /><a href="javascript:history.go(-1);">Cancel</a></p>
<form action="<?php echo $paypal_url ?>" method="post" id="paypal_form">
    <input type="hidden" name="upload" value="1" />
    <input type="hidden" name="address_override" value="0" />
    <input type="hidden" name="first_name" value="<?php echo $address['address_firstname'] ?>" />
    <input type="hidden" name="last_name" value="<?php echo $address['address_lastname'] ?>" />
    <input type="hidden" name="address1" value="<?php echo $address['address_address1'] ?>" />
    <?php if ($address['address_address2'])
        { ?>
            <input type="hidden" name="address2" value="<?php echo $address['address_address2'] ?>" />
<? } ?>
        <input type="hidden" name="city" value="<?php echo $address['address_city'] ?>" />
        <input type="hidden" name="zip" value="<?php echo $address['address_postcode'] ?>" />
        <input type="hidden" name="country" value="<?php echo $country['ISO_code'] ?>" />
<?php if ($state)
        {
 ?>
            <input type="hidden" name="state" value="<?php echo $country['iso_code'] ?>" />
    <? } ?>
        <input type="hidden" name="amount" value="<?php echo $amount ?>" />
        <input type="hidden" name="email" value="<?php echo $customer->customer_email ?>" />
    <?php
        if (!$discount)
        {
            foreach($products as $k=>$product)
            {
                $index=$k+1;
                 $quantity = $cart->containProduct($product->product_ID);
                 echo "<input type='hidden' name='item_name_{$index}' value='{$product->product_name}' />
			<input type='hidden' name='amount_{$index}' value='{$product->getPrice(true,$quantity['quantity'])}' />
			<input type='hidden' name='quantity_{$index}' value='{$quantity['quantity']}' />";
            }
            echo "<input type='hidden' name='shipping_1' value='{$shipping}' />";
        }
        else
        {
            echo "<input type='hidden' name='item_name_1' value='My Cart' />
			<input type='hidden' name='amount_1' value='{$total}' />
			<input type='hidden' name='quantity_1' value='1' />";
        }
    ?>
        <input type="hidden" name="business" value="<?php echo $business ?>" />
        <input type="hidden" name="receiver_email" value="<?php echo $business ?>" />
        <input type="hidden" name="cmd" value="_cart" />
        <input type="hidden" name="charset" value="utf-8" />
        <input type="hidden" name="currency_code" value="<?php echo $currency->iso_code ?>" />
        <input type="hidden" name="payer_id" value="<?php echo $customer->customer_ID ?>" />
        <input type="hidden" name="payer_email" value="<?php echo $customer->customer_email ?>" />
        <input type="hidden" name="custom" value="<?php echo $cart->cart_ID ?>" />
        <input type="hidden" name="return" value="<?php echo $url ?>/confirmation/key/<?php echo $customer->customer_salt ?>/id_cart/<?php echo $cart_ID ?>" />
        <input type="hidden" name="cancel_return" value="<?php echo $url ?>" />
        <input type="hidden" name="notify_url" value="<?php echo $url ?>/paypal/site/validation" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="cbt" value="Return to shop" />
    <input type="submit" value="submit" />
</form>