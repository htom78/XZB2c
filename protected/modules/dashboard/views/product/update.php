
<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product_form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<div style="display: none;"></div>
<div  id="product_general_content" class="content_col">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-edit-form fieldset-legend">主要信息</h4>

            </div>

            <div id="group_fields4" class="fieldset fieldset-wide">

                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label for="product_active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'product_active', lookup::items('YesAndNo'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'product_active',
                                        'name' => 'product[product_active]',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="product_status">状态 <span class="required">*</span></label></td>
                                <td class="value">
                                    <select multiple="multiple" name="product[product_status][]" id="product_satus" class="required-entry input-text multiselect">
                                    <?php
                                        foreach (lookup::items('ProductStatus') as $key => $row)
                                        {
                                            $sel = "";
                                            foreach ($status as $item)
                                            {
                                                if ($key == $item)
                                                {
                                                    $sel = "selected='true'";
                                                    break;
                                                }
                                            }

                                            echo "<option value='{$key}'{$sel}>{$row}</option>";
                                        }
                                    ?>

                                    </select>

                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"><label for="name">名称<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'id' => 'name',
                                            'name' => 'product[product_name]',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_name'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="sef">SEF<span class="required">*</span></label></td
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_SEF', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'product[product_SEF]',
                                            'id' => 'sef',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_SEF'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="description">介绍<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        $this->widget('ext.xheditor.JXHEditor', array(
                                            'model' => $model,
                                            'attribute' => 'product_description',
                                            'language' => 'zh_cn',
                                            'options' => array(
                                                'upImgUrl' => "/dashboard/default/upload/immediate/1",
                                                'upImgExt' => 'jpg,jpeg,gif,png',
                                                'tools' => 'full',
                                                'upFlashUrl' => "/dashboard/default/upload/immediate/1",
                                                'upFlashExt' => 'swf',
                                                'upMediaUrl' => '/dashboard/default/upload/immediate/1',
                                                'upMediaExt' => 'avi,flv',
                                            ),
                                            'htmlOptions' => array('class' => 'required-entry required-entry textarea',
                                                'id' => 'product_description',
                                                'name' => 'product[product_description]',),
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_description'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="short">缩略介绍<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textArea($model, 'product_short_description', array(
                                            'class' => 'required-entry required-entry textarea',
                                            'cols' => '15',
                                            'rows' => '1',
                                            'name' => 'product[product_short_description]',
                                            'id' => 'short',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_short_description'); ?></span></td>
                                    <td><small></small></td>
                                </tr>

                                <tr>
                                    <td class="label"> <label for="weight">重量<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_weight', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'product[product_weight]',
                                            'id' => 'weight',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'product_weight'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>

                                <tr>
                                    <td class="label"> <label for="sku">SKU<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_SKU', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'product[product_SKU]',
                                            'id' => 'sku',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'product_SKU'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"> <label for="quantity">库存<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_quantity', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'name' => 'product[product_quantity]',
                                            'id' => 'quantity',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'product_quantity'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" id="product_price_content" class="content_col">
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-edit-form fieldset-legend">价格</h4>

                </div>
                <div id="group_fields4" class="fieldset fieldset-wide">

                    <div class="hor-scroll">
                        <table cellspacing="0" class="form-list">
                            <tbody>
                                <tr>
                                    <td class="label"><label for="product_price">价格<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_price', array(
                                            'class' => 'required-entry input-text',
                                            'name' => 'product[product_price]',
                                            'id' => 'product_price',
                                        )); ?>

                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_price'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="product_wholesale_price">批发价格</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_wholesale_price', array(
                                            'class' => 'required-entry input-text',
                                            'name' => 'product[product_wholesale_price]',
                                            'id' => 'product_wholesale_price',
                                        )); ?>

                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_wholesale_prices'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="product_reducetion_price">减免价格</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_reducetion_price', array(
                                            'class' => 'required-entry input-text',
                                            'name' => 'product[product_reducetion_price]',
                                            'id' => 'product_reducetion_price',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_reducetion_price'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="product_reducetion_percent">折扣</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_reducetion_percent', array(
                                            'class' => 'required-entry input-text',
                                            'name' => 'product[product_reducetion_percent]',
                                            'id' => 'product_reducetion_percent',
                                        )); ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_reducetion_percent'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="product_reducetion_from">启始时间</label></td>
                                    <td class="value">
                                <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'product[product_reducetion_from]',
                                            'model' => $model,
                                            'attribute' => 'product_reducetion_from',
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'required-entry input-text',
                                                'id' => 'product_reducetion_from',
                                                'style' => 'width: 110px ! important;'
                                            ),
                                        ));
                                ?>

                                        <img style="" title="Select Date" id="special_from_date_trig" class="v-middle" alt="" src="<?php echo $this->module->registerImage('grid-cal.gif') ?>" />
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_reducetion_from'); ?></span></td>
                                    <td><small></small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="product_reducetion_to">结束时间</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'product_reducetion_to', array(
                                            'class' => 'required-entry input-text',
                                            'name' => 'product[product_reducetion_to]',
                                            'id' => 'product_reducetion_to',
                                            'style' => 'width: 110px ! important;'
                                        ));
                                ?>
                                        <img style="" title="Select Date" id="special_from_date_trig" class="v-middle" alt="" src="<?php echo $this->module->registerImage('grid-cal.gif') ?>" />
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'product_reducetion_to'); ?></span></td>
                                    <td><small></small></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:none;" id="product_SEO_content" class="content_col">
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-edit-form fieldset-legend">Product SEO</h4>
                </div>
                <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
                    <div class="hor-scroll">
                        <table cellspacing="0" class="form-list">
                            <tbody>
                                <tr>
                                    <td class="label"><label for="seo_title">页面标题</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model->seo, 'SEO_title', array(
                                            'class' => 'input-text',
                                            'id' => 'seo_title',
                                            'name' => 'seo[SEO_title]',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo, 'SEO_title'); ?></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>

                                <tr>
                                    <td class="label"><label for="seo_keyword">Meta Keywords</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model->seo, 'SEO_keyword', array(
                                            'class' => 'input-text',
                                            'id' => 'seo_keyword',
                                            'name' => 'seo[SEO_keyword]',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo, 'SEO_keyword'); ?></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="seo_description">Meta Description</label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textArea($model->seo, 'SEO_description', array(
                                            'class' => 'textarea',
                                            'cols' => '15',
                                            'rows' => '2',
                                            'name' => 'seo[SEO_description]',
                                            'id' => 'seo_description',
                                        )); ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo, 'SEO_description'); ?></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div style="display:none;" id="product_category_content" class="content_col">
    <?php
                                        $this->widget('CTreeView',
                                            array('data' => $tree, 'htmlOptions' => array('class' => "treeview-red", 'id' => 'attribute_treeview'))
                                        );
    ?>
                                        <span class="nobr"><?php echo $form->error($model, 'product_category_ID'); ?></span>
                                    </div
                                    <div style="display:none;" id="product_image_content" class="content_col">
                                        <div class="entry-edit">
                                            <div class="entry-edit-head">
                                                <h4 class="icon-head head-edit-form fieldset-legend">产品图片</h4>
                                            </div>

        <?php
                                        $this->widget('TradeGrid', array(
                                            'dataProvider' => $image->search(),
                                            'filter' => $image,
                                            'htmlOptions' => array(
                                                'class' => 'hor-scroll',
                                            ),
                                            'columns' => array(
                                                array(
                                                    'header' => '缩略图',
                                                    'name' => 'image_name',
                                                    'type' => 'raw',
                                                    'value' => 'CHtml::image($data->getMiddleImage(),null,array("width"=>100))',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '标签',
                                                    'name' => 'image_legend',
                                                    'value' => 'CHtml::textField("image[$data->image_ID][legend]",$data->image_legend)',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '封面',
                                                    'name' => 'image_cover',
                                                    'value' => 'CHtml::radioButton("cover",$data->image_cover,array("onclick"=>"updateCover({$data->image_ID},{$data->image_product_ID})"))',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '顺序',
                                                    'name' => 'image_position',
                                                    'value' => 'CHtml::textField("image[$data->image_ID][position]",$data->image_position)',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'class' => 'CButtonColumn',
                                                    'template' => '{delete}',
                                                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("product/imagedelete",array("id"=>$data->primaryKey))',
                                                ),
                                            )
                                        ));

                                        $this->widget('CSwfUpload', array(
                                            'jsHandlerUrl' => $this->module->getAssetsUrl() . '/js/swfupload/handlers.js', //Relative path
                                            'jsURL' => $this->module->getAssetsUrl() . '/js/swfupload/swfupload.js',
                                            'swfURL' => $this->module->getAssetsUrl() . '/js/swfupload/swfupload.swf',
                                            'postParams' => array('product_ID' => $model->product_ID),
                                            'config' => array(
                                                'use_query_string' => false,
                                                'upload_url' => Yii::app()->controller->createUrl("product/upload"),
                                                'file_size_limit' => '2 MB',
                                                'file_types' => '*.jpg;*.png;*.gif',
                                                'file_types_description' => 'Image Files',
                                                'file_upload_limit' => 0,
                                                'file_queue_error_handler' => 'js:fileQueueError',
                                                'file_dialog_complete_handler' => 'js:fileDialogComplete',
                                                'upload_progress_handler' => 'js:uploadProgress',
                                                'upload_error_handler' => 'js:uploadError',
                                                'upload_success_handler' => 'js:uploadSuccess',
                                                'upload_complete_handler' => 'js:uploadComplete',
                                                'custom_settings' => array('upload_target' => 'divFileProgressContainer'),
                                                'button_image_url' => $this->module->getAssetsUrl() . "/js/swfupload/images/button_image.png",
                                                'button_placeholder_id' => 'swfupload',
                                                'button_width' => 180,
                                                'button_height' => 18,
                                                'button_text' => '<span>' . Yii::t('messageFile', 'ButtonLabel') . '(Max 2 MB)</span>',
                                                'button_text_style' => '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
                                                'button_text_top_padding' => 0,
                                                'button_text_left_padding' => 18,
                                                'button_window_mode' => 'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
                                                'button_cursor' => 'js:SWFUpload.CURSOR.HAND',
                                            ),
                                            )
                                        );
        ?>


                                        <div class="uploader">
                                            <div id="divFileProgressContainer" class="file-row"></div>
                                            <div class="flex"><span id="swfupload"></span></div>
                                            <div id="thumbnails"></div>
                                        </div>


                                    </div>

                                </div>




                                        <div style="display:none;" id="product_discount_content" class="content_col">
                                            <div class="entry-edit">
                                                <div class="entry-edit-head">
                                                    <h4 class="icon-head head-edit-form fieldset-legend">产品折扣</h4>
                                                </div>

                                                <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
                                                    <div class="hor-scroll">
                                                        <table cellspacing="0" class="form-list">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="label"><label for="seo_title">折扣应用产品数量下限</label></td>
                                                                    <td class="value">
                                <?php
                                    
                                        echo $form->textField($discount, 'quantity', array(
                                            'class' => 'input-text',
                                            'id' => 'discount_quantity',
                                            'name' => 'discount[quantity]',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'quantity'); ?></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="seo_title">折扣量(%或者定量)</label></td>
                                    <td class="value">
<?php
                                        echo $form->textField($discount, 'value', array(
                                            'class' => 'input-text',
                                            'id' => 'discount_value',
                                            'name' => 'discount[value]',
                                        ));
?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($model, 'value'); ?></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>
                                <tr>
                                    <td class="label"><label for="discount_type">折扣类型</label></td>
                                    <td class="value">
<?php
                                        echo CHtml::dropDownList('discount[discount_type_ID]', 1, array('1' => 'By %', '2' => 'By Amount'))
?>
                                    </td>
                                    <td class="scope-label"><span class="nobr"><?php echo $form->error($discount, 'discount_type_ID'); ?></span></td>
                                    <td><small>&nbsp;</small></td>

                                </tr>

                                <tr>
                                    <td class="label"></td>
                                    <td class="value">
                                        <?php echo $form->hiddenField($model,'product_ID',array('name'=>'discount[product_ID]'))?>
                                       <button id="discount_save" type="button" class="scalable save"><span>保存</span></button>
                                    </td>
                                    <td class="scope-label"><span class="nobr"></span></td>
                                    <td><small>&nbsp;</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>        

<?php
                                        $this->endWidget();
                                        $this->widget('TradeGrid', array(
                                            'dataProvider' => $discount->search(),
                                            'filter' => $discount,
                                            'htmlOptions' => array(
                                                'class' => 'hor-scroll',
                                            ),
                                            'columns' => array(
                                                array(
                                                    'header' => 'ID',
                                                    'name' => 'quantity_ID',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '类型',
                                                    'name' => 'discount_type_ID',
                                                    'value' => 'lookup::item("DiscountType",$data->discount_type_ID)',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '最小数量',
                                                    'name' => 'quantity',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'header' => '值',
                                                    'name' => 'value',
                                                    'type' => 'raw',
                                                    'filter' => false,
                                                ),
                                                array(
                                                    'class' => 'CButtonColumn',
                                                    'template' => '{delete}',
                                                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("product/discountdelete",array("id"=>$data->primaryKey))',
                                                ),
                                            )
                                        ));
?>
    </div>

</div>