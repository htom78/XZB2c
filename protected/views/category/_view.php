<?php
if($index==0)
{
    echo "<ul class='nav2'>";
}
else if(($index)%4==0 && $index>3)
{
    echo "<ul class='nav2'>";
}

$cls=$end='';
if($index+1==$widget->dataProvider->getItemCount() || ($index+1)%4==0)
{
   $cls='n_llast';
   $end="</ul>";
}
?>
<li class='<?php echo $cls?>'>
    <a href="<?php echo $data->getUrl() ?>" class="p_l_img"><img src="/media/products/middle/<?php echo $data->cover->image_name;?>" alt="<?php echo $data->cover->image_legend; ?>" />
       <?php
        echo $data->getImageMask();
        ?>
    </a>
    <?php
        echo $data->getWholesaleMask();
     ?>
    <div>
        <a href="<?php echo $data->getUrl() ?>" class="p_l_title">
            <?php echo $data->product_name ?>
        </a>
        <span class='p_l_desc'><?php echo $data->product_short_description?></span>
        <?php
           if($data->isReduction()){
               echo "<span class='linegray'>{$data->displayPrice(false)}</span> <span class='orange'>{$data->displayPrice()}</span>";
           }
           else
           {
                echo "<span class='orange'>{$data->displayPrice(false)}</span>";
           }
            ?>
    </div>
     <?php echo $data->getShippingMask()?>
</li>
<?php echo $end;?>