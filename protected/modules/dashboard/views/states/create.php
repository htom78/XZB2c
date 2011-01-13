<?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'states_form',
            ));
?>

<div style="display: none;"></div>
<div  id="product_general_content" class="content_col">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-edit-form fieldset-legend">主要信息</h4>
            </div>
            <div id="group_fields4" class="fieldset fieldset-wide">

                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label for="active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'active', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'active',
                                        'name' => 'state[active]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                                <tr>
                                    <td class="label"> <label for="name">名称<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'state[name]',
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
                                    <td class="label"> <label for="iso_code">ISO 代码<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'iso_code', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'state[iso_code]',
                                            'id' => 'iso_code',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'iso_code'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                               <tr>
                                <td class="label"><label for="zone">区域 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'zone_ID', zone::items(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'zone',
                                        'name' => 'state[zone_ID]',
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
                                    echo $form->dropDownList($model, 'country_ID', country::items(true), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'country',
                                        'name' => 'state[country_ID]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php $this->endWidget()?>