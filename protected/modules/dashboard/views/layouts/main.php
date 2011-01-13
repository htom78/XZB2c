<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        echo $this->module->registerCss('reset.css', 'all');
        echo $this->module->registerCss('boxes.css', 'all');
        echo $this->module->registerCss('print.css', 'print');
        echo $this->module->registerCss('menu.css', 'screen,projection');
        ?>
        <!--[if lt IE 8]>
        <?php  echo $this->module->registerCss('iestyles.css', 'all'); ?>
     
       <![endif]-->
        <!--[if lt IE 7]>
           <?php  echo $this->module->registerCss('below_ie7.css', 'all'); ?>
       
        <script type="text/javascript" src="http://www.demo.com/js/lib/ds-sleight.js" defer></script>
        <script type="text/javascript" src="http://www.demo.com/js/varien/iehover-fix.js"></script>
        <![endif]-->
        <!--[if IE 7]>
           <?php  echo $this->module->registerCss('ie7.css', 'all'); ?>
       
        <![endif]-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

   <body id="html-body"class=" adminhtml-dashboard-index">
        <div class="wrapper">
            <noscript>
                <div class="noscript">
                    <div class="noscript-inner">
                        <p><strong>系统检测到你没有开机Javascript</strong></p>
                        <p>你必须开启javascript才能正常使用系统功能</p>
                    </div>
                </div>
            </noscript>

   <div class="header">
                <div class="header-top">


                    <div class="header-right">
                        <p class="super">
                            Logged in as <?php echo Yii::app()->user->getName();?><span class="separator">|</span><?php echo date('Y-m-d') ?><span class="separator">|</span><a href="/site/logout" class="link-logout">Log Out</a>
                        </p>


                    </div>
                </div>
                <div class="clear"></div>

                <!-- menu start -->

                <!-- menu end -->
                <div class="nav-bar">



              <?php $this->renderPartial('/layouts/_backMenu'); ?>

                </div>

            </div>
            <div class="middle" id="anchor-content">
                <div id="page:main-container">
                    <div id="messages"></div>


                    <div class="content-header">
                          <?php $this->widget('ContentHeader'); ?>

                    </div>

                    <?php echo $content; ?>

                </div>
            </div>
            <div class="footer">



            </div>
        </div>
        <div id="loading-mask" style="display:none">
            <p class="loader" id="loading_mask_loader"><img src="<?php echo $this->module->registerImage('ajax-loader-tr.gif') ?>" alt="ajax-loading" /><br/>Please wait...</p>
        </div>
          <div id="nav-active-index" style="display:none">
            <p><?php echo $active ?></p>
        </div>



    </body>

</html>