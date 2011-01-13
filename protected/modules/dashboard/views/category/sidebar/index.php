<div class="categories-side-col">
    <div class="content-header">
        <h3 class="icon-head head-categories">Categories</h3>
        <button style="" class="scalable add" type="button" id="add_root_category_button"><span>添加根分类</span></button><br/>
        <button style=""class="scalable add" type="button" id="add_subcategory_button"><span>添加子分类</span></button><br/>
        <button style=""class="scalable" type="button" id="sort_rootcategory_button"><span>根分类排序</span></button>
       
    </div>
     <?php

             $this->widget(
                        'CTreeView',
                        array('data' =>$tree,'htmlOptions'=>array('class'=>"treeview-red",'id'=>'attribute_treeview'))

                );
        ?>
</div>


