<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'currency_form',
        ));
?>
<div  id="address_general_content" class="content_col">
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">币种信息</h4>
                </div>
                <div class="fieldset">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"> <label for="name">名称<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'name', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'currency[name]',
                                        'id' => 'name',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'name'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="iso">ISO代码</label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'iso_code', array(
                                        'class' => 'input-text',
                                        'name' => 'currency[iso_code]',
                                        'id' => 'iso',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'iso_code'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                               <tr>
                                <td class="label"> <label for="sign">符号<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'sign', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'currency[sign]',
                                        'id' => 'sign',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'sign'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                             <tr>
                                <td class="label"> <label for="conversion_rate">汇率<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'conversion_rate', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'name' => 'currency[conversion_rate]',
                                        'id' => 'conversion_rate',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'conversion_rate'); ?></span>
                                </td>
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