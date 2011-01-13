<div class="side_box mb_12 side_deals">
    <div class="side_title">Daily Deals</div>
    <div class="side_deals_box">
        <ul class="nav2">
            <?php
foreach (product_entity::model()->daliy(4)->findAll() as $row)
{
        echo <<<HTML
<li>
 <a class="p_l_img" href="{$row->getUrl()}"><img alt="{$row->gallery->base->image_label}" src="{$row->gallery->base->getSmall()}"></a>
                      <div>
                    <a class="p_l_title" href="{$row->getUrl()}">{$row->product_name}</a>
                     <span class='p_l_desc'>{$row->product_short_description}</span>
                    <span class="linegray">\${$row->getRegularPrice()}</span><span class="orange">\${$row->getSpecialPrice()}</span></div>
                    <a class="button button_cart_m mt_10" href="/product/cart/id/{$row->product_ID}/qty/{$row->stock->stock_min_qty_cart}"></a>
                   <a class="button button_checko_m mt_10 ml_6" href="/product/checkout/id/{$row->product_ID}/qty/{$row->stock->stock_min_qty_cart}"></a>
               
 </li>

HTML;

}
?>

           </ul>
        <div class="fix"></div>
    </div>
</div>


