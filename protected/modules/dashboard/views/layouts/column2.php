<?php $this->beginContent('/layouts/edit'); ?>
 <div class="middle" id="anchor-content">
                <div id="page:main-container">

                    <div class="columns">
                        <div id="page:left" class="side-col">
                           <?php $this->renderPartial($this->sideView,$this->sideData); ?>
                        </div>

                        <div id="content" class="main-col">
                            <div class="main-col-inner">
                                <div id="messages"></div>
                                <div class="content-header">
                                    <?php $this->widget('ContentHeader'); ?>

                                </div>
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->endContent(); ?>