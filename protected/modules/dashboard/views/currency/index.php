
<div id="currencyGrid">
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
                            'name'=>'currency_ID',
                            'type'=>'raw',
                        ),
                        array(
                                'header'=>'币种',
                                'name'=>'name',
                                'type'=>'raw',
                        ),
                        array(
                                'header'=>'标准代码',
                                'name'=>'iso_code',
                                'type'=>'raw',
                        ),
                        array(
                            'header'=>'符号',
                            'name'=>'sign',
                            'type'=>'raw',
                        ),
                        array(
                            'header'=>'汇率',
                            'name'=>'conversion_rate',
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
