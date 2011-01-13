
<div id="customerGrid">
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
                    'name' => 'customer_ID',
                    'type' => 'raw',
                ),
                array(
                    'header' => '姓',
                    'name' => 'customer_last_name',
                    'type' => 'raw',
                ),
                array(
                    'header' => '名',
                    'name' => 'customer_first_name',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Email',
                    'name' => 'customer_email',
                    'type' => 'raw',
                ),
                array(
                    'header' => '激活',
                    'name' => 'customer_active',
                    'value' => 'lookup::item("YesAndNo",$data->customer_active)',
                    'filter' => lookup::items('YesAndNo'),
                    'type' => 'raw',
                ),
                array(
                    'header' => '注册时间',
                    'name' => 'customer_create',
                    'filter' => false,
                    'type' => 'raw'
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update} {delete}',
                ),
            )
        ));
      
    ?>
</div>
