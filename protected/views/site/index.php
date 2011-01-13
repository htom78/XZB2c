<?php $this->pageTitle='R4DS,DS R4,R4 DS,R4 DSi,R4i Gold,R4 SDHC,R4i SDHC,R4i Ultra Online Top provider' ?>

<div class="mb_12 content_banner" >
    <div id="index_banner">
        <a href="/e3-card-reader-ps3-35-psn.html" style="display:block"><img src="/images/banner5.jpg" alt="ps3 downgrade 3.5/3.42" /></a>
        <a href="/p3-hub3-break-ps3-no-need-external-ps3-harddisc.html" style="display:none"><img src="/images/banner2.jpg" alt="ps3 hub" /></a>
       <a href="/site/page/view/xmas" style="display:block"><img src="/images/banner1.jpg" alt="r4 ps3 xmas christmas" /></a>
        <a href="/ps3-external-HDD-1-5t-110-ps3-games.html" style="display:none"><img src="/images/banner4.jpg" alt="ps3 external HDD" /></a>
        <ul class="c_b_num">
            <li>ps3 downgrade 3.5/3.42</li>
            <li>P3 HUB3</li>
            <li>Merry Christmas </li>
            <li class="c_b_last">PS3 External HDD 110 Games</li>
        </ul>

    </div>
    <div class="fix"></div>
</div>

<div class="fix"></div>
<div class="content_box mb_12 most_viewed">
    <h2>Most Viewed</h2>
    <ul class="nav1">
        <?php
   
        ?>

    </ul>
    <div class="fix"></div>
</div>

<div class="content_box mb_12 prduct_list">
    <h2>Newarrival nds card</h2>

   <?php

        $this->widget('TradeList', array(
            'dataProvider' => new CActiveDataProvider('product_entity', array(
                'criteria' =>  product_entity::model()->latest(12),
            )),
            'itemView' => '_product',
            'template' => "{items}",));?>

    <div class="fix"></div>
</div>

<div class="content_box mb_12 prduct_list">
    <h2>Featured Products</h2>
      <?php
     
        $this->widget('TradeList', array(
            'dataProvider' => new CActiveDataProvider('product_entity', array(
                'criteria' =>  product_entity::model()->feature(),
            )),
            'itemView' => '_product',
            'template' => "{items}",));?>
   
    <div class="fix"></div>
</div>

<div class="content_box mb_12 index_desc" id="i_tabs">

    <h2><a href="javascript://;" class="i_d_sel">Why Us</a> <a href="javascript://;">Guarantee</a> <a href="javascript://;" class="i_d_last">Professional Service</a></h2>

    <div class="i_d_box  i_d_box1">
        <img src="/images/index_help_icon1.gif" alt="" />
        <p> In recent years competition has grown rapidly and with so many companies to choose from,Why us?
            CARDSNDS.COM tries to integrate the industry resource to provide our customer
            all the accessories for the most popular Video Game consoles: Nintendo Wii, Microsoft XBox 360, Sony PSP, Sony PlayStation 3, Nintendo DS, Nintendo GBA, and more,
            at the most preferential price, reliable quality and considerate service.
        </p>
        <div class="fix"></div>
    </div>
    <div class="i_d_box  i_d_box1" style="display:none">
        <img src="/images/index_help_icon2.gif" alt="" />
        <p>All our product comes with 3 months warranty.
           We are so sure that our products will work for you that we offer you the possibility of a total refund (minus the expenses of shipment) if you are unsatisfied with the results after 3 months of treatment (90 days).
           We offer you 3 months because we believe that 90 days is more than enough to see results.
           If any quality problem happened in 3 months since you buy our products, please contact us,
          and your goods arrive faulty or develop a fault within the first 7 days, you can return them to us for refund or replacement
        </p>
        <div class="fix"></div>
    </div>
    <div class="i_d_box  i_d_box1" style="display:none">
        <img src="/images/index_help_icon3.gif" alt="" />
        <p>Customers of cardsnds.com have toll-free access to highly trained and award winning Customer Service,10 hours a day, seven days a week.
            Our Customer Service can provide solutions for a variety of questions you might have during
            your selection process.

        </p>
        <div class="fix"></div>
    </div>

</div>