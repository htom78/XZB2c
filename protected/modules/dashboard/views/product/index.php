
<div id="productGrid">
        <?php
      
        $this->widget('TradeGrid',array(
                'dataProvider'=>$model->search(),
                'filter'=>$model,
               
                'htmlOptions'=>array(
                        'class'=>'hor-scroll',
                ),

                'columns'=>array(

                        array(
                            'header'=>'编号',
                            'name'=>'product_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'名称',
                                'name'=>'product_name',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'默认分类',
                                'name'=>'product_def_category_ID',
                                'value'=>'$data->defCategory->category_name',
                                'filter'=> category_entity::categoryOptionData(),
                                'type'=>'raw',
                        ),

                        array(
                                'header'=>'SKU',
                                'name'=>'product_SKU',
                                'type'=>'raw',
                        ),

                        array(
                                'header'=>'零售价',
                                'name'=>'product_price',
                                'type'=>'raw',
                                ),
                        array(
                                'header'=>'库存',
                                'name'=>'product_quantity',
                                'type'=>'raw',
                        ),
                         array(
                                'header'=>'状态',
                                'name'=>'product_status',
                                'type'=>'raw',
                        ),
                        array(
                                'class'=>'CButtonColumn',
                                'template'=>'{update} {delete}',

                        ),
                )
        ));
        ?>
</div>
