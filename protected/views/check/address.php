
<div id="navigate">
    <a href="/" class="n_home">Home</a> - <span>Address Details</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>
<div class="content_box mb_12">
    <div class="pop_box">
        <h1>Address Details</h1>
        <div class="member_main">
            
            <div class="sunmm_box">

                <p class="gray">Please choose a delivery address or create a new address. Your personal information is safe with us. If any questions, you can refer to our <a href="/privacy">Privacy Policy</a>.</p>
                <?php
                    echo CHtml::dropDownList('quickAddr', $cart->cart_address_ID, $address);
                ?>
                <h3>Your delivery address</h3>
                <table width="32%" class="table1">
                        <tbody>
                            <?php if($shipping->address_company){?>

                             <tr class='alt'>
                                <td><?php echo $shipping->address_company;?></td>
                            </tr>
                            <?php }?>
                            <tr class="alt">
                                <td><?php echo $shipping->address_firstname .' '. $shipping->address_lastname; ?></td>
                            </tr>
                             <tr>
                                <td><?php echo $shipping->address_address1;?></td>
                            </tr>
                            <?php if($shipping->address_address2){?>

                             <tr class='alt'>
                                <td><?php echo $shipping->address_address2;?></td>
                            </tr>
                            <?php }?>
                             <tr>
                                <td><?php echo $shipping->address_postcode . ' '.$shipping->address_city;?></td>
                            </tr>
                             <tr class="alt">
                                 <td ><?php echo country::item($shipping->address_country_ID)?></td>
                            </tr>
                        </tbody>
                    </table>
                 <div class="fl mt_10"><a href="/address/create">Add a new address</a></div>
                  <div class="fix"></div>
            </div>
         
            <div class="sunmm_box">
                <h3>Additional Order Comments &amp; Information(optional):</h3>
                <textarea name="comment" rows="6" cols="80" ></textarea>
            </div>
     
                <div class="sunmm_box" style="background-color:#f8f8f8; padding:6px;">
                    <div class="fl mt_10"><a href="/">&laquo; continue to shopping</a></div>
                    <div class="fr">   <?php echo CHtml::submitButton('', array('class' => 'button ubutton button_checkstep','onclick'=>'location.href="/check/shipping"')); ?></div>
                    <div class="fix"></div>
                </div>

        </div>
        <div class="fix"></div>
    </div>
</div>


