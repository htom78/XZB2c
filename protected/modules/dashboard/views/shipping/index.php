<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'shipping_form',
        ));
?>
<div  id="product_general_content" class="content_col">
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">手续费</h4>
                </div>
                <div class="fieldset">
                      <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label for="FREE_SHIPPING_PRICE">免运费</label></td>
                                <td class="value">
                                    $<input type="text" value="<?php echo $config?>" name="SHIPPING[SHIPPING-SHIPPING_FREE_PRICE]" size="6" id="FREE_SHIPPING_PRICE">
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                          
                            </tbody>

                      </table>
                        <p style="font-weight: bold; font-size: 11px;">注意:</p>
                        <ul style="list-style-type: disc; font-size: 11px; color: rgb(127, 127, 127); margin-left: 30px; line-height: 20px;">
                            <li>当设置为0时,表示该设置关闭</li>
                            <li>优惠券应用不涉及免运费的设置</li>
                        </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
     
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">运费</h4>
                </div>
               
                <div class="grid fieldset">
                    <table cellspacing="0" cellpadding="0" class="table space">
					<tbody>
                 <?php
                    echo "<tr>";
                    echo CHtml::activeDropDownList($carrier,'carrier_ID', carrier_entity::items(), array(
                         'class' => 'required-entry required-entry input-select',
                         'id' => 'carrier',
                         'name'=>'carrier_ID'
                    ));
                    echo "</tr>";
                    echo ' <tr class="headings">
						<th style="padding:4px 6px;">区域 / 范围</th>';
                    foreach($carrier->weight as $row)
                    {
                        $l1=floatval($row->delimiter1);
                        $l2=floatval($row->delimiter2);
                        echo "<th style='font-size: 11px; padding:4px 6px;'>{$l1}kg to {$l2}kg</th>";
                    }

                    echo '</tr>';
                    foreach($carrier->zones as $row)
                    {
                        echo "<tr class='filter'><th style='height: 30px; padding:4px 6px;'>{$row->name}</th>";
                        foreach($carrier->weight as $item)
                        {
                            $delivery=delivery::model()->findByAttributes(array('carrier_ID'=>$carrier->carrier_ID,'zone_ID'=>$row->zone_ID,'weight_range_ID'=>$item->weight_ID));
                         
                            if($delivery)
                            {
                                $fee=$delivery->price;
                                $name="feeUpdate[{$delivery->delivery_ID}]";
                            }
                            else
                            {
                                  $fee='0.00';
                                  $name="feeAdd[{$row->zone_ID}-{$item->weight_ID}]";
                            }
                          
                            echo "<td class='center'>$ <input type='text'  class='required-entry required-entry input-text' style='width: 45px; height:18px;' value='{$fee}' name='{$name}' ></td>";
                        }
                        echo '</tr>';
                    }
                    ?>
                 
				</tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
</div>
<?php $this->endWidget() ?>