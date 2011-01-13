<div id="navigate">
    <a href="/" class="n_home">Home</a> - <span>Login</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>

<div class="content_box mb_12">
    <div class="pop_box">
        <h1>Login</h1>
        <p class="gray">Please login to check your order status, place your order for quick checkout or manage your account information. </p>
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
        )); ?>
        <table width="651" align="center" cellpadding="3" cellspacing="1" style="padding:18px 24px;">

            <tr>
                <td width="16%" height="42"><strong>Email:</strong></td>
                <td width="35%"> <?php echo $form->textField($model,'email',array('class'=>'input_text1')); ?></td>
                <td width="49%"><strong class="red ml_6"><?php echo $form->error($model,'email'); ?></strong></td>
            </tr>
            <tr>
                <td height="42"><strong>Password:</strong></td>
                <td><?php echo $form->passwordField($model,'password',array('class'=>'input_text1')); ?></td>
                <td><strong class="red ml_6"><?php echo $form->error($model,'password'); ?></strong></td>
            </tr>
          
            <tr>
                <td colspan="3" height="72" style="padding-left:110px;">
                    <?php echo CHtml::submitButton('Login',array('class'=>'button button_simple')); ?>
                   
                </td>
            </tr>

          <tr><td colspan="3">
                   <a href="/site/pwd" class="gray">Forget your password?</a><br/>
                   <a href="/site/register" class="gray"> New customer? Register here</a>
                   
              </td></tr>
        </table>
         <?php $this->endWidget(); ?>
    </div>
</div>
