<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'address_form',
        ));
?>
<div  id="address_general_content" class="content_col">
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">客户地址信息</h4>
                </div>
                <div class="fieldset">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"> <label for="email">客户Email<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    $this->widget('CAutoComplete', array(
                                        'model' => $model,
                                        'attribute' => 'address_customer_email',
                                        'url' => array('customerEmail'),
                                        'htmlOptions' => array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'address[address_customer_email]',
                                            'id' => 'name'),
                                    ));
                                ?>

                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_customer_ID'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                            <tr>
                                <td class="label"> <label for="alias">名称<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_alias', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_alias]',
                                        'id' => 'alias',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_alias'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="company">公司</label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_company', array(
                                        'class' => 'input-text',
                                        'name' => 'address[address_company]',
                                        'id' => 'company',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_company'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                               <tr>
                                <td class="label"> <label for="lastname">姓<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_lastname', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_lastname]',
                                        'id' => 'lastname',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_lastname'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="firstname">名<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_firstname', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_firstname]',
                                        'id' => 'firstname',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_firstname'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="address1">地址1<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_address1', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_address1]',
                                        'id' => 'address1',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_address1'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="address2">地址2</label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_address2', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_address2]',
                                        'id' => 'address2',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_address2'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                        
                              <tr>
                                <td class="label"> <label for="postcode">邮编<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_postcode', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_postcode]',
                                        'id' => 'postcode',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_postcode'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="city">城市<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_city', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_city]',
                                        'id' => 'city',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_city'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"><label for="active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'address_active', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'active',
                                        'name' => 'address[address_active]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                             <tr>
                                <td class="label"><label for="country">国家 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'address_country_ID', country::items(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'country',
                                        'name' => 'address[address_country_ID]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="state">州/省 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'address_state_ID', array(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'state',
                                        'name' => 'address[address_state_ID]',
                                        'prompt'=>'-----------------------------------------------------------------'
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="phone">电话<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'address_phone', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'address[address_phone]',
                                        'id' => 'phone',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'address_phone'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                              <tr>
                                    <td class="label"><label for="other">备注</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textArea($model, 'address_other', array(
                                            'class' => 'required-entry required-entry textarea',
                                            'cols' => '15',
                                            'rows' => '1',
                                            'name' => 'address[address_other]',
                                            'id' => 'other',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'address_other'); ?></span></td>
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
jQuery(function($) {
$('#country').change(function(){
    if($('#country').val())
        {
    <?php
 echo CHtml::ajax(array(
            'url' => array('ajaxState'),
            'beforeSend' => 'function(id) {$("#loading-mask").show();}',
             'complete' => 'function(id) {$("#loading-mask").hide();}',
              'replace'=>'#state',
              'type'=>'POST'
             ));
?>
}});
$('#country').trigger('change');
    });
    /*]]>*/
</script>