
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
                    'name' => 'address_ID',
                    'type' => 'raw',
                ),
                array(
                    'header' => '姓',
                    'name' => 'address_lastname',
                    'type' => 'raw',
                ),
                array(
                    'header' => '名',
                    'name' => 'address_firstname',
                    'type' => 'raw',
                ),
                array(
                    'header' => '国家',
                    'name' => 'address_country_ID',
                    'value'=>'country::item($data->address_country_ID)',
                    'filter'=>  country::items(),
                    'type' => 'raw',
                ),
                array(
                    'header'=>'州/省',
                    'name'=>'address_state_ID',
                    'value'=>'state::item($data->address_state_ID)',
                    'filter'=>  state::items(),
                    'type'=>'raw',
                ),
                    array(
                    'header' => '城市',
                    'name' => 'address_city',
                    'type' => 'raw',
                ),
                array(
                    'header' => '激活',
                    'name' => 'address_active',
                    'value' => 'lookup::item("YesAndNo",$data->address_active)',
                    'filter' => lookup::items('YesAndNo'),
                    'type' => 'raw',
                ),
                array(
                    'header' => '邮编',
                    'name' => 'address_postcode',
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
