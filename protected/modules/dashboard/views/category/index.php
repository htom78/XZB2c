
    <ul class="tabs-horiz" id="product_tabs">
    <li>
        <a class="tab-item-link active" title="General Information" id="category_general" href="#">
            <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>基本信息</span>
        </a>

    </li>
 
</ul>

<?php
 
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'category_form',
        'enableAjaxValidation'=>false,
)); ?>

<div id="category_tab_content">
    <div class="content_col" id="category_general_content">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-edit-form fieldset-legend">基本信息</h4>
                <div class="form-buttons"></div>
            </div>
            <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>

                            <tr>
                                <td colspan="100" class="hidden"><input type="hidden" value="1" name="general[path]" id="group_3path"></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="name">名称<span class="required">*</span></label></td>
                                <td class="value">
                                    <?php

                                    echo $form->textField($model,'category_name',array(
                                    'class'=>'required-entry required-entry input-text',
                                    'id'=>'name',
                                    'name'=>'category[category_name]',

                                    ));
                                    ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_name'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="category_active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model,'category_active',lookup::items('YesAndNo'),array(
                                          'class'=>'required-entry required-entry input-select',
                                    'id'=>'category_active',
                                    'name'=>'category[category_active]',
                                    ));
                               ?>
                                  
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="category_SEF">URL key</label></td>
                                <td class="value">
                                    <?php
                                    echo $form->textField($model,'category_SEF',array(
                                    'class'=>'required-entry required-entry input-text',
                                    'id'=>'category_SEF',
                                    'name'=>'category[category_SEF]',

                                    ));
                                    ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_SEF'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="description">Description</label></td>
                                <td class="value">
                                      <?php
                                    echo $form->textArea($model,'category_description',array(
                                    'class'=>'required-entry required-entry textarea',
                                    'id'=>'description',
                                    'name'=>'category[category_description]',
                                    'cols'=>'15',
                                    'rows'=>'2',
                                    ));
                     ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model,'category_description'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>



                            <tr>
                                <td class="label"><label for="seo_title">页面标题</label></td>
                                <td class="value">
                                    <?php
                                    echo $form->textField($model->seo,'SEO_title',array(
                                    'class'=>'input-text',
                                    'id'=>'seo_title',
                                    'name'=>'seo[SEO_title]',

                                    ));
                                    ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'SEO_title'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="seo_keyword">Meta Keywords</label></td>
                                <td class="value">
                                    <?php
                                    echo $form->textField($model->seo,'SEO_keyword',array(
                                    'class'=>'input-text',
                                    'id'=>'seo_keyword',
                                    'name'=>'seo[SEO_keyword]',

                                    ));
                                    ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'SEO_keyword'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="seo_description">Meta Description</label></td>
                                <td class="value">
                                    <?php echo $form->textArea($model->seo,'SEO_description',array(
                                    'class'=>'textarea',
                                    'cols'=>'15',
                                    'rows'=>'2',
                                    'name'=>'seo[SEO_description]',
                                    'id'=>'seo_description',
                                    )); ?>
                                </td>
                                <td class="scope-label"><span class="nobr"><?php echo $form->error($model->seo,'SEO_description'); ?></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

  
</div>
<?php  echo  $form->hiddenField($model,'category_ID',array(
'id'=>'category_ID','name'=>'pk'
));
echo  $form->hiddenField($model,'category_parent_ID',array(
'id'=>'category_parent_ID','name'=>'category[category_parent_ID]'
));
echo  $form->hiddenField($model,'category_ID',array(
'id'=>'category_ID','name'=>'category_ID'
));

?>
<?php $this->endWidget(); ?>


