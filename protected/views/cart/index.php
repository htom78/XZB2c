<div id="navigate">
    <a href="/" class="n_home">Home</a> - <span>Shopping Cart</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>
<div class="content_box mb_12">
    <div class="pop_box">
        <h1>Shoppping Cart</h1>
        <div class="member_main">
            <div class="pass error">
                <ul id="flash">
                    <li class="flash"><?php echo Yii::app()->user->getFlash('cart') ?></li>
                </ul>
            </div>

            <table width="100%" class="table1">
                <thead>
                    <tr>
                        <th width="43%">Product</th>
                        <th width="15%">Qty</th>
                        <th width="15%">Unite Price</th>
                        <th width="14%">Total Price</th>
                        <th width="13%" class="thlast">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $grandTotal = 0;
                        $currencySign=currency::getSign();
                     
                        foreach ($cart->products as $row)
                        {
                            $quantity = $cart->containProduct($row->product_ID);
                            $unitPrice=$row->getPrice(true,$quantity['quantity']);
                            $subtotal = $unitPrice * $quantity['quantity'];
                            $productTotal+=$subtotal;
                            echo <<<EOC
                        <tr>
                        <td><a href="{$row->getUrl()}"><img alt="{$row->cover->image_legend}" src="/media/products/small/{$row->cover->image_name}"></a><br/><a href="{$row->getUrl()}"> {$row->product_name}</a></td>
                        <td>
                            <a href="/cart/quantity/product/{$row->product_ID}/op/down"><image src="/images/bag_close.gif" style="padding: 0pt; border: 0pt none;" name="subAmount"></a>
                            <input style="width: 20px; text-align: center; padding: 2px 4px; color: black;" maxlength="3" value="{$quantity['quantity']}" id="num1725">
                             <a href="/cart/quantity/product/{$row->product_ID}/op/up"><image src="/images/bag_open.gif" style="display: inline; padding: 0pt; border: 0pt none;" name="subAmount"></a>
                        </td>
                        <td><span class="orange fw700">{$currencySign}{$unitPrice}</span></td>
                        <td><span class="orange fw700">{$currencySign}{$subtotal}</span></td>
                        <td><a href="/cart/quantity/product/{$row->product_ID}/op/remove" class="button ubutton button_del"></a></td>
                    </tr>
EOC;
                        }
                    ?>
                    </tbody>
                </table>
                <div class="ar t_count">
                    <form method="POST" action="/cart/coupon">
                        <p style="float: left; margin-top: 3px; display: inline;">Coupon Code:
                            <input type="text" size="20" value="" name="code">
                            <input type="hidden" name="token" value="<?php echo md5(Yii::app()->user->getStateKeyPrefix()) ?>"/>
                            <input type="hidden" name="total" value="<?php echo $productTotal ?>" >
                            <input type="submit" size="20" value="Check" />

                        </p>
                    </form>

                    <strong class="t_c1">Total Products:<span class="red"><?php echo $currencySign . $productTotal ?></span></strong>
                </div>
<?php
               
                        $cart->checkDiscounts($cart->getOrderTotal(1));
                        //Coupon segment
                        $discounts = cart_discount::items($cart->cart_ID);
                        if (sizeof($discounts) >= 1)
                        {
                     
                            echo "  
                                 <table width='100%' class='table1'>
                <thead>
                    <tr>
                        <th width='10%'>code</th>
                        <th width='70%'>description</th>
                         <th width='10%'>Discount Price</th>
                        <th width='10%' class='thlast'>Action</th>
                    </tr>
                </thead>
                <tbody>";
                            foreach ($discounts as $row)
                            {
                                if ($row['discount_type'] == 3)
                                {
                                    $value = 'Freeshipping';
                                }
                                else if ($row['discount_type'] == 2)
                                {
                                    $value=product_entity::decoratePrice($row['discount_value'],true);
                                }
                                else if ($row['discount_type'] == 1)
                                {
                                    $value=$product_entity::decoratePrice($productTotal*(1-$row['discount_value']/100),true);
                                }
                              
                                echo <<<EOC
                        <tr>
                        <td><span class="gray fw700">{$row['discount_name']}</span></td>
                        <td><span class="orange fw700">{$row['discount_description']}</span></td>
                        <td><span class="orange fw700">{$value}</span></td>
                        <td><a href="/cart/coupon/remove/{$row['discount_ID']}" class="button ubutton button_del"></a></td>
                    </tr>
EOC;
                            }
                            $discountTotal=product_entity::decoratePrice($cart->getOrderTotal(2),true);
                            echo "</tbody></table><div class='ar t_count'><strong class='t_c1'>Total Coupon:<span class='red'>{$discountTotal}</span></strong></div>";
                        }
?>
                        <div class="ar t_count">
<?php
                        //shipping segment
                      
                      $grandTotal=$cart->getOrderTotal();
                        if (!$cart->isFreeshipping())
                        {
                            $remain = product_entity::decoratePrice(configuration::item('SHIPPING', 'SHIPPING_FREE_PRICE')- $grandTotal,true);
                            echo " <p style='margin-top: 3px; display: inline;'>Remaining amount to be added to your cart in order to obtain free shipping: <span class='green'>{$remain}</span></p>";
                           
                            if ($cart->cart_carrier_ID && $cart->cart_address_ID)
                            {
                                $shippingFee =  product_entity::decoratePrice($cart->getOrderTotal(5),true);
                              
                                echo " <strong class='t_c1'>Total Shipping:<span class='red'>{$shippingFee}</span></strong>";
                            }
                        }
                        else
                        {
                            echo "<p style='margin-top: 3px; display: inline;'>You have obtain free shipping</p>";
                        }
?>
                    </div>

                    <div class="ar t_count">
                        <?php echo CHtml::dropDownList('currency',Yii::app()->user->getState('currency_ID'),currency::getCurrencies())?>
                       
                        <strong class="t_c1">GrandTotal:<span class="red"><?php echo product_entity::decoratePrice($grandTotal,true); ?></span></strong>
            </div>
            <div class="fl mt_10"><a href="/">&laquo; continue to shopping</a></div>
            <p class="ar"><input  type="button"  value="" id="check_btn" class="button ubutton button_checkstep " /></p>
        </div>
        <div class="fix"></div>
    </div>
</div>
