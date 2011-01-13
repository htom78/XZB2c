
<div id="zoneGrid">
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
                            'name'=>'carrier_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'名称',
                                'name'=>'carrier_name',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'激活',
                                'name'=>'carrier_active',
                                'value'=>'lookup::item("YesAndNo",$data->carrier_active)',
                                'filter'=> lookup::items('YesAndNo'),
                                'type'=>'raw',
                        ),
                        array(
                              'header'=>'货运费用',
                              'name'=>'carrier_shipping_handing',
                              'value'=>'lookup::item("YesAndNo",$data->carrier_shipping_handing)',
                              'filter'=> lookup::items('YesAndNo'),
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
