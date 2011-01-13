<div class="side_box mb_12 side_category">
    <a href="/categories">Explorer All Category</a>
</div>
<div class="side_box mb_12 side_catlist">
    <div class="side_title">Browse Categorys</div>
    <div id="side_accordion">
        <ul>
            <?php
            $roots=category_entity::rootCategory();
            if(!isset($this->acc_active))
            {
                $active_index=0;
            }
            else
            {
               
                $active_index=$this->acc_active;
            }
            
            $i=0;
            foreach ($roots as $value)
            {
                if($i==$active_index)
                {
                    $active="sc_currall";
                }
                else
                {
                    $active=null;
                }
                
                $children=category_entity::getChirdren($value['category_ID']);
                echo "<li><h3 class='{$active}'><a href='/{$value['category_SEF']}'>{$value['category_name']}</a></h3>";

                echo "<ul style='display:block;'>";
                
                foreach ($children as $item)
                {
                    echo "<li><a href='/{$item['category_SEF']}'>{$item['category_name']}</a></li>";
                }
                echo "</ul></li>";
                $i++;
            }
            ?>

        </ul>
    </div>
    <div class="fix"></div>
</div>
