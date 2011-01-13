<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'coupon_form',
        ));
?>
<div  id="address_general_content" class="content_col">
        <div class="box-left" style="width:70%">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">优惠券信息</h4>
                </div>
                <div class="fieldset">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"> <label for="code">代码<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_name', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'discount[discount_name]',
                                        'id' => 'code',
                                    ));
                                ?>
                                    <a href="#" onclick="gencode(8)"> 生成</a>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_name'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="type">类型 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'discount_type', lookup::items('DiscountType'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'type',
                                        'name' => 'discount[discount_type]',
                                        'onchange' => 'freeshipping(this)',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr id="valuetr">
                                <td class="label"> <label for="value">值<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_value', array(
                                        'class' => 'input-text',
                                        'name' => 'discount[discount_value]',
                                        'id' => 'value',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_value'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="description">介绍<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_description', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'discount[discount_description]',
                                        'id' => 'description',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_description'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="firstname">启用分类<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    $this->widget('CTreeView',
                                        array('data' => $tree, 'htmlOptions' => array('class' => "treeview-red", 'id' => 'attribute_treeview'))
                                    );
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="quantity">数量<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_quantity', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'discount[discount_quantity]',
                                        'id' => 'quantity',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_quantity'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="per_user">每用户可用数<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_quantity_per_user', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'discount[discount_quantity_per_user]',
                                        'id' => 'per_user',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_quantity_per_user'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="minimal">最小金额<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_minimal', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'discount[discount_minimal]',
                                        'id' => 'minimal',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_minimal'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'discount_active', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'active',
                                        'name' => 'discount[discount_active]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="cumulable">是否兼容其他优惠券 </label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'discount_cumulable', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'cumulable',
                                        'name' => 'discount[discount_cumulable]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="cumulable_reduction">是否兼容打折 </label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'discount_cumulable_reduction', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'cumulable_reduction',
                                        'name' => 'discount[discount_cumulable_reduction]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="email">指定客户Email<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    $this->widget('CAutoComplete', array(
                                        'model' => $model,
                                        'attribute' => 'discount_customer_email',
                                        'url' => array('customerEmail'),
                                        'htmlOptions' => array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'discount[discount_customer_email]',
                                            'id' => 'email'),
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'discount_customer_ID'); ?></span>
                                </td>
                                <td><small>不填或者错误,默认向所有用户开放</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="discount_from">启始时间</label></td>
                                <td class="value">
                                <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'discount[discount_from]',
                                        'model' => $model,
                                        'attribute' => 'discount_from',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'required-entry input-text',
                                            'id' => 'discount_from',
                                            'style' => 'width: 110px ! important;'
                                        ),
                                    ));
                                ?>
                                    <img class="v-middle" alt="" src="<?php echo $this->module->registerImage('grid-cal.gif') ?>" />
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'discount_from'); ?></span></td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="discount_to">结束时间</label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'discount_to', array(
                                        'class' => 'required-entry input-text',
                                        'name' => 'discount[discount_to]',
                                        'id' => 'discount_to',
                                        'style' => 'width: 110px ! important;'
                                    ));
                                ?>
                                    <img class="v-middle" alt="" src="<?php echo $this->module->registerImage('grid-cal.gif') ?>" />
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'discount_to'); ?></span></td>
                                <td><small></small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
</div>
<?php $this->endWidget() ?>
<script type="text/javascript">
    /*<![CDATA[*/
    function gencode(size){
        $('#code').val('');
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var res='';
        for (var i = 1; i <= size; ++i)
            res += chars.charAt(Math.floor(Math.random() * chars.length));
        $('#code').val(res);
    }

    function freeshipping(type)
    {
        if(type.value==3)
        {
            $('#value').val(0);
            $('#valuetr').hide();
        }
        else
        {
            $('#valuetr').show();
        }
    }
    /*]]>*/
</script>