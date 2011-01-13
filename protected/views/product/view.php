<?php
    $this->pageTitle = $model->product_name;
    $tree = $model->defCategory->getFamliyTree();
?>
<div id="navigate">
        <a href="/" class="n_home">Home</a>
    <?php
        if ($tree)
        {
            foreach ($tree as $key => $item)
            {
                echo " - <a href='/{$item['category_SEF']}'>{$item['category_name']}</a>";
            }
        }
        echo " - <a href='/{$model->defCategory->category_SEF}'>{$model->defCategory->category_name}</a>";
    ?>
        <span class="n_icol"></span>
        <span class="n_icor"></span>
</div>


<div class="content_box mb_12">
        <div class="product_box">
            <div class="fl">
<?php echo $model->getWholesaleMask('large'); ?>
            <img id="base_img" src="/media/products/<?php echo $model->cover->image_name;?>" alt="<?php echo $model->cover->image_legend ?>" />
<?php echo $model->getImageMask(); ?>
            <span class="p_imgt" id="base_img_lable"><?php echo $model->cover->image_legend ?></span>
            <div class="p_b_imglist" id="imgList">
                <a href="#" class="p_b_ilsel" >
                    <img src="/media/products/small/<?php echo $model->cover->image_name;?>"  alt="<?php echo $model->cover->image_legend ?>">
                    <span class="hidden">/media/products/<?php echo $model->cover->image_name; ?></span>
                </a>
                <?php
                    foreach ($model->images as $row)
                    {
                        if ($row->image_ID != $model->cover->image_ID)
                        {
                            echo "<a href='#'><img src='/media/products/small/{$row->image_name}' alt='{$row->image_legend}' />
                        <span class='hidden'>/media/products/{$row->image_name}</span>
                        </a>";
                        }
                    }
                ?>
                </div>
                <div class="fix">
                </div>
            </div>
            <div class="fr">
                <h1><?php echo $model->product_name ?></h1>
                <?php echo $model->getShippingMask('large') ?>
                <ul>
                    <input type="hidden" id="product_SEF" value="<?php echo $model->product_SEF; ?>" name="product_SEF">
                <?php
                    if ($model->isReduction()){
                       echo "<li><span class='p_b_t'>Regular Price:</span> <span class='linegray fw700'>{$model->displayPrice(false)}</span></li>
                       <li class='p_b_specialp'><span class='orange f16 fw700'>{$model->displayPrice()}</span><span class='p_b_date'> End: {$model->product_reducetion_to}</span></li>";
                    }else{
                        echo "<li><span class='p_b_t'>Now Price:</span> <span class='orange f16 fw700'>{$model->displayPrice(false)}</span></li>";
                    }
                ?>
                <li><span class="p_b_t">Model:</span><?php echo $model->product_SKU ?></li>
                <li><span class="p_b_t">STATUS:</span><?php
                    if ($model->product_quantity >5){
                        echo CHtml::tag('span', array('class' => 'blue'),'In Stock', true);
                    }else{
                        echo CHtml::tag('span', array('class' => 'red f16 fw700'), 'Out of Stock', true);
                    }
                ?></li>
                <li><span class="p_b_t">Shipping:</span><img src="/images/fshipping_small.gif" alt="" /> <span class="fw700 green">Free Shipping</span></li>
                <li><span class="p_b_t">Quantity:</span> <input id="product_qty"  type="text" value="1" class="w10" maxlength="3"  /></li>
                <li class="p_b_tools p_b_last">
                    <div  style=" float:left; width:180px">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style">
                            <a href="http://addthis.com/bookmark.php?v=250&amp;username=xa-4c6b987639489b5c" class="addthis_button_compact">Share</a>
                            <span class="addthis_separator">|</span>
                            <a class="addthis_button_facebook"></a>
                            <a class="addthis_button_myspace"></a>
                            <a class="addthis_button_google"></a>
                            <a class="addthis_button_twitter"></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c6b987639489b5c"></script>
                        <!-- AddThis Button END -->
                    </div>
                    <div class="fix"></div>
                </li>
                <li class="p_buttons p_b_last">
<?php
                    if ($model->product_quantity >5){
                        echo '<input type="button" name="cart" id="add-cart" value="" class="button button_cart" />';
                    }else{
                        echo '<input type="button" name="cart" value="" class="button button_cart button_cartfalse" />';
                    }
?>
                </li>
            </ul>
        </div>
        <div class="fix"></div>
    </div>
</div>
<!--/product_box-->
<div class="content_box mb_12 index_desc product_info">
    <h2><a href="javascript:void();" class="i_d_sel">Product Description</a></h2>
    <div class="i_d_box"><?php echo $model->product_description; ?></div>
</div>
<div class="content_box mb_12 index_desc product_info" id="product_info">
<h2><a href="javascript:void();" class="i_d_sel">Relate Products</a> <a href="javascript:void();">Promotion Information</a></h2>
<div>
    <div class="fix"></div></div>
    <div class="i_d_box hidden">
</div>
</div>
<!--/product info-->
