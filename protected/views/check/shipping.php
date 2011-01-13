<div id="navigate">
    <a href="/" class="n_home">Home</a> - <span>Address Details</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>
<div class="content_box mb_12">
    <div class="pop_box">
        <h1>Address Details</h1>
        <div class="member_main">
            <form action="/check/shipping" method="POST">
                <table width="100%" class="table1">
                    <thead>
                        <tr>
                            <th width="7%"></th>
                            <th width="25%">Shipping Method</th>
                            <th width="43%">Shipping Infromation</th>
                            <th width="25%">Shipping Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($carrier as $row)
                            {
                                $select='';
                                if($row['selected'])
                                    $select='checked';
                                $price=product_entity::decoratePrice($row['price'], true);
                                echo "  <tr>
                            <td><input type='radio' name='carrier' value='{$row['carrier_ID']}' {$select}/></td>
                            <td>{$row['carrier_name']}</td>
                            <td>{$row['carrier_description']}</td>
                            <td><span class='orange fw700'>{$price}</span></td>
                             <tr>";
                            }
                            ?>
                    </tbody>
                </table>
       
            <div class="sunmm_box" style="background-color:#f8f8f8; padding:6px;">
                <div class="fl mt_10"><a href="/">&laquo; continue to shopping</a></div>
                <div class="fr">   <?php echo CHtml::submitButton('', array('class' => 'button ubutton button_checkstep')); ?></div>
                <div class="fix"></div>
            </div>
     </form>
        </div>
        <div class="fix"></div>
    </div>
</div>