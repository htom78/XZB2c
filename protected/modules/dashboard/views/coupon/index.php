
<div id="addressGrid">
    <?php
        $this->widget('TradeGrid', array(
            'dataProvider' => $model->search(),
            'filter' => $model,
            'htmlOptions' => array(
                'class' => 'hor-scroll',
            ),
            'columns' => array(
                array(
                    'header' => '编号',
                    'name' => 'discount_ID',
                    'type' => 'raw',
                ),
                array(
                    'header' => '代码',
                    'name' => 'discount_name',
                    'type' => 'raw',
                ),
                array(
                    'header' => '介绍',
                    'name' => 'discount_description',
                    'type' => 'raw',
                    'value'=>'substr($data->discount_description, 0, 20);'
                ),
                array(
                    'header' => '类型',
                    'name' => 'discount_type',
                    'value'=>'lookup::item("DiscountType",$data->discount_type)',
                    'filter'=>  lookup::items("DiscountType"),
                    'type' => 'raw',
                ),
                array(
                    'header'=>'值',
                    'name'=>'discount_value',
                    'value'=>'floatval($data->discount_value) . (($data->discount_type==1) ? "%":"")',
                    'type'=>'raw',
                ),
                    array(
                    'header' => '到期时间',
                    'name' => 'discount_to',
                    'type' => 'raw',
                ),
                array(
                    'header' => '激活',
                    'name' => 'discount_active',
                    'value' => 'lookup::item("YesAndNo",$data->discount_active)',
                    'filter' => lookup::items('YesAndNo'),
                    'type' => 'raw',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update} {delete}',
                ),
            )
        ));

    ?>
</div>
