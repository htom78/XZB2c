<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer_form',
        ));
?>
<div  id="customer_general_content" class="content_col">
        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">客户信息</h4>
                </div>
                <div class="fieldset">
                      <table cellspacing="0" class="form-list">
                        <tbody>
                             <tr>
                                <td class="label"><label for="gender">性别 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->RadioButtonList($model, 'customer_gender', array(0=>'Male',1=>'Female',2=>'Unknow'), array(
                                        'class' => 'required-entry required-entry input-radio',
                                        'id' => 'gender',
                                        'name' => 'customer[customer_gender]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'customer_gender'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                               
                                  <tr>
                                    <td class="label"> <label for="lasttname">姓<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'customer_last_name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'customer[customer_last_name]',
                                            'id' => 'last_name',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'customer_last_name'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                 <tr>
                                    <td class="label"> <label for="firstname">名<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'customer_first_name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'customer[customer_first_name]',
                                            'id' => 'first_name',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'customer_first_name'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                 <tr>
                                    <td class="label"> <label for="email">Email<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'customer_email', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'customer[customer_email]',
                                            'id' => 'email',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'customer_email'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                   <tr>
                                    <td class="label"> <label for="password">Password<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->passwordField($model, 'customer_password', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'customer[customer_password]',
                                            'id' => 'password',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'customer_password'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                            <tr>
                                <td class="label"><label for="active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'customer_active', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'active',
                                        'name' => 'customer[customer_active]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                               <tr>
                                <td class="label"><label for="def_group">默认分组 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'customer_default_group_ID',  group_entity::items(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'def_group',
                                        'name' => 'customer[customer_default_group_ID]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'customer_default_group_ID'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                              <tr>
                                <td class="label"><label for="customer_group">分组挂载<span class="required">*</span></label></td>
                                <td class="value">
                                    <select multiple="multiple" name="customer_group[]" id="product_satus" class="required-entry input-text multiselect">
                                    <?php
                                        foreach (group_entity::items() as $key => $row)
                                        {
                                            $sel = "";
                                            if (isset($groups) && !empty($groups))
                                            {
                                                foreach ($groups as $item)
                                                {
                                                    if ($key == $item)
                                                    {
                                                        $sel = "selected='true'";
                                                        break;
                                                    }
                                                }
                                            }
                                            echo "<option value='{$key}'{$sel}>{$row}</option>";
                                        }
                                    ?>
                                    </select>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            </tbody>

                      </table>
                       
                </div>
            </div>
        </div>
        <div class="clear"></div>
</div>
<?php $this->endWidget() ?>