
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
                            'name'=>'country_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'名称',
                                'name'=>'name',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'区域',
                                'name'=>'zone_ID',
                                'type'=>'raw',
                                'value'=>'zone::item($data->zone_ID)',
                                'filter'=>zone::items(),
                        ),
                        array(
                                'header'=>'ISO code',
                                'name'=>'ISO_code',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'包含州',
                                'name'=>'contain_states',
                                'value'=>'lookup::item("YesAndNo",$data->contain_states)',
                                'filter'=> lookup::items('YesAndNo'),
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'激活',
                                'name'=>'active',
                                'value'=>'lookup::item("YesAndNo",$data->active)',
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
