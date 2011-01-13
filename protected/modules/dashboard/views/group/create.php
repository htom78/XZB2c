<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'group_form',
        ));
?>
<div  id="customer_general_content" class="content_col">
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">客户组信息</h4>
                </div>
                <div class="fieldset">
                      <table cellspacing="0" class="form-list">
                        <tbody>
                                  <tr>
                                    <td class="label"> <label for="name">名称<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'group_name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'group[group_name]',
                                            'id' => 'name',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'group_name'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                 <tr>
                                    <td class="label"> <label for="reduction">折扣<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'group_reduction', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'group[group_reduction]',
                                            'id' => 'reduction',
                                        ));
                                ?> %
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'group_reduction'); ?></span>
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