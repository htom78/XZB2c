<div  id="customer_general_content" class="content_col">
        <div class="box-left entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">客户组信息</h4>
                </div>
    
               <div class="order-totals">
                   <table width="100%" cellspacing="0">
                        <col>
                        <col width="1">
                        <tbody>
                            <tr class="0">
                                <td class="label">
                                   <h3> <?php echo $model->group_name?></h3>
                                </td>
                                <td>
                                   <strong><a href="/dashboard/group/update/id/<?php $model->group_ID?>"><span class="price">修改</span></a></strong>
                                </td>
                            </tr>
                                 <tr class="0">
                                <td class="label">
                                   折扣
                                </td>
                                <td>
                                     <strong><span class="price"><?php echo $model->group_reduction?></span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="clear"></div>
    
        <div id="customerGrid">
    <?php
        $this->widget('TradeGrid', array(
            'dataProvider' => $dataProvider,
            'filter' => $customer,
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
                    'template' => '{view}{update} {delete}',
                    'viewButtonUrl'=>'Yii::app()->controller->createUrl("dashboard/customer/view",array("id"=>$data->primaryKey))',
                    'updateButtonUrl'=>'Yii::app()->controller->createUrl("dashboard/udpate/view",array("id"=>$data->primaryKey))',
                    'deleteButtonUrl'=>'Yii::app()->controller->createUrl("dashboard/customer/delete",array("id"=>$data->primaryKey))',
                ),
            )
        ));
    ?>
</div>
 <div class="clear"></div>
</div>