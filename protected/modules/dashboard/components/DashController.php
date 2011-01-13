<?php

    class DashController extends CController
    {

        public $layout = 'column1';
        public $menu_active = 0;
        public $htmlOption = array('class' => 'head-dashboard', 'header' => "Dashboard");
        public $breadcrumbs = array();
        public $sideView;
        public $sideData=array();

        public function __construct($id, $module=null)
        {

            parent::__construct($id, $module);
            $this->registerScript();
        }

        protected function registerScript()
        {
            $cs = Yii::app()->getClientScript();
            $cs->registerCoreScript('jquery');
            $cs->registerScriptFile($this->module->getAssetsUrl() . '/js/menu.js', CClientScript::POS_END);
            $script = "  $('#nav li.level0:eq({$this->menu_active})').addClass('active');
            $('nav li.level0>a').click(function(){ return false;});";
            $cs->registerScript('nav_control', $script, CClientScript::POS_READY);
        }

      

    }

?>
