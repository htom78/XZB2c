<?php


    class ZoneController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "区域", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'zone-add',
                        'header' => '添加区域',
                    ),
                    ));
            $model = new zone('search');
            if (isset($_GET['zone']))
            {
                $model->attributes = $_GET['zone'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加区域", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $zone=new zone();
            if($_POST['zone'])
            {
                $zone->attributes=$_POST['zone'];
                if($zone->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $zone));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑区域", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
           $zone=$this->loadModel();
            if($_POST['zone'])
            {
                $zone->attributes=$_POST['zone'];
                if($zone->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $zone));
        }

          public function actionDelete()
        {
            if (Yii::app()->request->isPostRequest)
            {

                  $this->loadModel()->delete();

                $this->redirect(array('index'));
            }
            else
                throw new CHttpException(400, 'Invalid request...');
        }

          public function loadModel()
        {
            if ($this->_model == null)
            {
                if (isset($_GET['id']))
                {
                    $condition = '';
                    $this->_model = zone::model()->findByPk($_GET['id'], $condition);
                }
                if ($this->_model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }

            return $this->_model;
        }

        private function constructScript($scenario='index')
        {
            switch ($scenario)
            {
                case 'index':
                    $script = "$('#zone-add').click(function(){location.href='/dashboard/zone/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#zone_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('zone_button', $script, CClientScript::POS_READY);
        }
    }

?>
