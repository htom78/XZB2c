
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
                            'name'=>'state_ID',
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
                                'header'=>'国家',
                                'name'=>'country_ID',
                                'type'=>'raw',
                                'value'=>'country::item($data->country_ID)',
                                'filter'=>country::items(true),
                        ),
                        array(
                                'header'=>'ISO code',
                                'name'=>'iso_code',
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
