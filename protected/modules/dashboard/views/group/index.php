
<div id="groupGrid">
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
                            'name'=>'group_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'名称',
                                'name'=>'group_name',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'折扣',
                                'name'=>'group_reduction',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'成员',
                                'name'=>'member',
                                'type'=>'raw',
                                'filter'=>FALSE,
                        ),
                        array(
                                'class'=>'CButtonColumn',
                                'template'=>'{view}{update} {delete}',

                        ),
                )
        ));
        ?>
</div>
