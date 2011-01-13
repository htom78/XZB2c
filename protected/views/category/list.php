
<div id="navigate">
    <a href="/" class="n_home">Home</a> - <span>All Categories</span>
    <span class="n_icol"></span>
    <span class="n_icor"></span>
</div>

<div class="content_box mb_12 all_categories">
    <div class="pop_box" style="padding:12px;">
        <h1>All Categories</h1>
        <?php
        foreach($roots as $row)
        {
          echo "<h2><a href='/{$row['category_SEF']}'>{$row['category_name']}</a></h2> <ul class='nav1'>";
          foreach (category_entity::getChirdren($row['category_ID']) as $item)
          {
              echo "<li><a href='/{$item['category_SEF']}'>{$item['category_name']}</a></li>";
          }
         echo " </ul><div class='fix'></div>";
        }
        ?>
    </div>
</div>

<div class="content_box mb_12  prduct_list" id="popular">
    <h2><a href="#popular" class="i_d_sel">Popular Products</a></h2>

    <?php
        /*
    $pop=product_entity::model()->popular()->findAll();
    $count=count($pop);
    foreach($pop as $key=>$row)
    {
        if($key==0)
        {
            echo "<ul class='nav2'>";
        }
        else if(($key)%4==0 && $key>3)
        {
            echo "<ul class='nav2'>";
        }

        $cls=$end='';
 if($key+1==$count || ($key+1)%4==0)
{
   $cls='n_llast';
   $end="</ul>";
}
        echo " <li class='{$cls}'>
                    <a href='{$row->getUrl()}'class='p_l_img'><img src='{$row->gallery->base->image_name}' alt='{$row->gallery->base->image_label}' /></a>
                   <div>
                    <a href='{$row->getUrl()}' class='p_l_title'>{$row->product_name}</a>
                     <span class='p_l_desc'>{$row->product_short_description}</span>
                       <span class='linegray'>\${$row->getRegularPrice()}</span>
                   <span class='orange'>\${$row->getSpecialPrice()}</span></div>
                    </li>";
    
            echo $end;
      
    }
*/
    ?>
    <div class="fix"></div>
</div>
