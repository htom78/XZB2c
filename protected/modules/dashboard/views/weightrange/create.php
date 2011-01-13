<?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'weight_form',
            ));
?>
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
                                <td class="label"><label for="carrier">货运渠道 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'carrier_ID', carrier_entity::items(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'carrier',
                                        'name' => 'weight[carrier_ID]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                                <tr>
                                    <td class="label"> <label for="delimiter1">下限<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'delimiter1', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'weight[delimiter1]',
                                            'id' => 'weight[delimiter1]',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'delimiter1'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"> <label for="delimiter2">上限<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'delimiter2', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'weight[delimiter2]',
                                            'id' => 'weight[delimiter2]',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'delimiter2'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php $this->endWidget()?>