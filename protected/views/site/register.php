
<div id="navigate">
    <a href="/" class="n_home">Home</a><span>>></span><span>Register</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>
<div class="content_box mb_12">
    <div class="pop_box" style="background: #fff;border:0;padding:16px 24px;margin:0;">
        <h1>Register for free</h1>
        <p class="gray">The form below allows you to create a profile which is necessary to place orders. Do not forget that this information is essential to use our services correctly. The fields marked with <span class="red" style="display:inline; float:none;width:auto;height:auto">*</span> are mandatory.</p>
        <?php
        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'register-form',
                'enableAjaxValidation'=>true,
        ));
        ?>
        <table cellspacing="1" cellpadding="3" align="center" style="padding:18px 24px;" >

            <tr><td width="19%" height="42">
                    <strong>Email address:</strong></td>
                <td width="27%">

                    <?php echo $form->textField($model,'customer_email',array(
                    'class'=>'input_text1')); ?>

                </td>
                <td width="54%"><span class="red ml_6 fw700">*</span><strong class="red ml_6"><?php echo $form->error($model,'customer_email'); ?></strong></td>
            </tr>

            <tr>
                <td width="19%" height="42"><strong>Gender:</strong></td>
                <td width="27%"><?php  echo CHtml::activeDropDownList($model,'customer_gender',array(0=>'Male',1=>'Female')); ?></td>
                <td width="54%">
                </td>
            </tr>
            <tr>
                <td width="19%" height="42"><strong>Password:</strong></td>
                <td width="27%"><?php echo $form->passwordField($model,'customer_pwd',array(
                    'class'=>'input_text1')); ?></td>
                <td width="54%">
                    <span class="red ml_6 fw700">*</span>
                    <strong class="red ml_6"><?php echo $form->error($model,'customer_pwd'); ?></strong>
                </td>
            </tr>
            <tr>
                <td width="19%" height="42"><strong>Confirm Password:</strong></td>
                <td width="27%"><?php
                    echo $form->passwordField($model,'password_repate',array(
                    'class'=>'input_text1'));?></td>
                <td width="54%">
                    <span class="red ml_6 fw700">*</span>
                    <strong class="red ml_6"> <?php echo $form->error($model,'password_repate'); ?></strong>
                </td>
            </tr>
            
            <tr>
                <td width="19%" height="42"><strong>Last Name:</strong></td>
                <td width="27%"><?php
                    echo $form->textField($model,'customer_lastname',array(
                    'class'=>'input_text1'));?></td>
                <td width="54%">
                    <span class="red ml_6 fw700">*</span>
                    <strong class="red ml_6"><?php echo $form->error($model,'customer_lastname'); ?></strong>
                </td>
            </tr>
            
            <tr>
                <td width="19%" height="42"><strong>First Name:</strong></td>
                <td width="27%"><?php
                    echo $form->textField($model,'customer_firstname',array(
                    'class'=>'input_text1'));?></td>
                <td width="54%">
                    <span class="red ml_6 fw700">*</span>
                    <strong class="red ml_6"><?php echo $form->error($model,'customer_firstname'); ?></strong>
                </td>
            </tr>

            <tr><td colspan="3" height="60" style="padding-left:190px">
                    <?php echo CHtml::submitButton('Register',array('class'=>'button button_simple')); ?>

                </td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
