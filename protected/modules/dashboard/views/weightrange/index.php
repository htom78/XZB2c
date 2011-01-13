
<div id="weightGrid">
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
                            'name'=>'weight_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'货运渠道',
                                'name'=>'carrier_ID',
                                'value'=>'carrier_entity::model()->findByPk($data->carrier_ID)->carrier_name',
                                'filter'=>carrier_entity::items(),
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'下限',
                                'name'=>'delimiter1',
                                'value'=>'"KG" . $data->delimiter1',
                                'type'=>'raw',
                        ),
                      array(
                                'header'=>'上限',
                                'name'=>'delimiter2',
                                'value'=>'"KG" . $data->delimiter2',
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
