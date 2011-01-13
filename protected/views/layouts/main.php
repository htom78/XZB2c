<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta name="google-site-verification" content="hZM01tFk8eqUq1saqoQvawMs9oiDAdzwRpqpgxZcbiI" />
        <link href="/css/style.css" rel="stylesheet" type="text/css" media="screen" />
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <link rel="alternate" type="application/rss+xml" title="Cardsnds Products" href="/feed.xml" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title><?php echo CHtml::encode($this->pageTitle); ?> </title>
        <style type="text/css">
            span { behavior: url(/script/iepngfix.htc) }
        </style>
 
    </head>
    <body>
          <div id="christmas_style"><div class="christmas_styleinner"><a href="/site/page/view/xmas"></a></div></div>
        <div id="main">
            <div id="page_top">
                <ul class="nav3">
                   
                    <?php
                        if(Yii::app()->user->isGuest){ 
                        ?>
                    <li id="ico2"><a href="/site/login" rel="nofollow" style=" margin-right:0; padding-right:0">Sign in</a> / <a href="/site/register" style="background:none; padding:0; margin-left:0" rel="nofollow">Register</a></li>
                   <?php }else{?>
                    <li id="ico2"><a href="/user" rel="nofollow" style=" margin-right:0; padding-right:0;"><?php echo Yii::app()->user->name ?></a> <a href="/site/logout" style="background:none; padding:0; margin:0; color:#999" rel="nofollow">(sign out)</a> / <a href="/site/register" style="background:none; padding:0; margin-left:0" rel="nofollow">Register</a></li>
                        <?php }?>
                    <li id="ico5"><a href="/user" rel="nofollow">My Account</a></li>
                    <li id="ico3"><a rel="nofollow" href="/help/contact">Contact us</a></li>

                </ul>

                <div class="page_desc">
                    <span>The World Renowned Nintendo DS Card Provider</span>
                </div>
            </div>


            <div id="header">
                <div id="logo"><strong><a href="/">Cards Nds</a></strong></div>
                <div class="logo_separate"></div>

                <div id="top_search">
                    <div class="t_search_form">

                        <form action="/site/search"  method="POST">
                            <input type="text" name="search" value="search something" onblur="if(this.value=='')this.value='search something'" onfocus="if(this.value=='search something')this.value=''" maxlength="255" class="t_sinput" tabindex="1" />
                            <input type="submit" name="tsbutton" id="tsbutton" value="" class="t_sbutton" tabindex="2" />
                        </form>
                    </div>
                    <div class="t_hot_search">
                        <span>HOT SEARCH:</span>
                        <?php
                            /*
                        foreach (search_term::model()->popular()->suggest()->findAll() as $row)
                        {
                            $str .= "<a href='/site/search/keyword/{$row->search_query}'>{$row->search_query}</a>,";
                        }
                        $str=rtrim($str,',');
                        echo $str;
                             * 
                             */
                        ?>

                    </div>

                </div>
                <div class="top_other fr">
                  <!--<a rel="nofollow" href="javascript:void(window.open('http://www.cardsnds.com/livezilla/chat.php','','width=590,height=580,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))">
                        <img src="http://www.cardsnds.com/livezilla/image.php?id=01" width="132" height="28" border="0" alt="LiveZilla Live Help" /></a>
                    <noscript><div><a href="http://www.cardsnds.com/livezilla/chat.php" target="_blank">Start Live Help Chat</a></div></noscript><div id="livezilla_tracking" style="display:none"></div>-->

                    <a href="/help/shipping" rel="nofollow"><img alt="R4,R4i Free Shipping" src="/images/freeshipping.gif" /></a>
                </div>

            </div>
            <!--/header -->


            <div id="menubar">
                <?php
                if($this->id==site)
                {
                    $ini_menu=true;
                }
                else
                {
                    $ini_menu=false;
                }
           
                $nav=$this->CreateWidget('zii.widgets.CMenu',array(
                        'htmlOptions'=>array(
                                'id'=>'menu',
                        ),
                        'items'=>array(
                                array('label'=>'Home<span></span>', 'url'=>'/','active'=>$ini_menu,'itemOptions'=>array('class'=>'m_first')),
                                array('label'=>'Category<span></span>', 'url'=>'/categories'),
                                array('label'=>'PS3 JailBreak<span></span>','url'=>'/buy-ps3-jailbreak'),
                                array('label'=>'New Arrivals<span></span>', 'url'=>array('/site/newarrival')),
                                array('label'=>'Promotion<span></span>', 'url'=>array('/site/promotion')),

                                array('label'=>'User Guide <span></span>','url'=>array('/help/guide'),'linkOptions'=>array('rel'=>'nofollow')),
                                array('label'=>'Contact<span></span>','url'=>array('/help/contact'),'linkOptions'=>array('rel'=>'nofollow')),
                                array('label'=>'About Us<span></span>','url'=>array('/help/about'),'linkOptions'=>array('rel'=>'nofollow')),
                        ),
                        'activeCssClass'=>'m_sel',
                        'encodeLabel'=>false,
                ));

                $nav->htmlOptions=array( 'id'=>'menu');
                $nav->run();
                ?>

            </div>
            <!-- menu -->

            <div id="home_columns">
                <?php echo $content;?>
            </div>
            <div id="footer">
               	<div class="footer_link">
                    <a href="/help/about" rel="nofollow">About Us</a>
                    <a href="/help/shipping" rel="nofollow">Shipping &amp; Tracking</a>
                    <a href="/help/return" rel="nofollow">Return &amp; Exchanges</a>
                    <a href="/help/privacy" rel="nofollow">Privacy Policy</a>
                    <a href="/help/terms" rel="nofollow">Terms &amp; Conditions</a>
                    <a href="/help/contact" rel="nofollow">Contact Us</a>
                     <a href="/sitemap.xml" rel="nofollow">Sitemap</a>
                    <a href="#page_top" class="back_top" rel="nofollow">TOP</a>

                </div>
                <?php
             
                foreach(category_entity::getChirdren(1) as $row)
                {
                    $cate.="<li><a href='/{$row['category_SEF']}'>{$row['category_name']}</a></li>";
                }

                ?>
                <ul class="nav4">
                    <?php echo $cate;?>
                </ul>

                <div class="fix"></div>
                <div class="footer_copyr"> &copy; 2000-2010 Cardsnds Inc.  All rights reserved. </div>
            </div>
            <!--/footer -->
            <img src="/images/f_secure_img.jpg" alt="" />
        </div>
        <!--/main -->
        <script type="text/javascript" src="/script/iepngfix/iepngfix_tilebg.js"></script>


    </body>
</html>