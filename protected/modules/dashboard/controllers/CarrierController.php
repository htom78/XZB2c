<?php

    class CarrierController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "货运渠道", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'carrier-add',
                        'header' => '添加渠道',
                    ),
                ));
            $model = new carrier_entity('search');
            if (isset($_GET['carrier_entity']))
            {
                $model->attributes = $_GET['carrier_entity'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加货运渠道", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $carrier = new carrier_entity();
            if ($_POST['carrier'])
            {
                $carrier->attributes = $_POST['carrier'];
                if ($carrier->save())
                {
                    if ($_POST['carrier_zone'])
                    {
                        carrier_zone::addment($carrier->carrier_ID, $_POST['carrier_zone']);
                    }
                    $this->redirect(array('index'));
                }
            }

            if ($_POST['carrier_zone'])
            {
                $zones=$_POST['carrier_zone'];
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $carrier, 'zones' => $zones));
        }

        public function actionUpdate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑货运渠道", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $carrier = $this->loadModel();
            if ($_POST['carrier'])
            {
                $carrier->attributes = $_POST['carrier'];
                if ($carrier->save())
                {
                     if ($_POST['carrier_zone'])
                    {
                        carrier_zone::updateHook($carrier->carrier_ID, $_POST['carrier_zone']);
                    }
                    $this->redirect(array('index'));
                }
            }

              if ($_POST['carrier_zone'])
            {
                $zones=$_POST['carrier_zone'];
            }
            else
            {
                $zones=carrier_zone::getZoneIDS($carrier->carrier_ID);
            }
            $this->constructScript('update');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $carrier,'zones'=>$zones));
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
                    $this->_model = carrier_entity::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#carrier-add').click(function(){location.href='/dashboard/carrier/create';});";
                    break;
                case 'create':
                case 'update':
                    $script = "jQuery('#form-save').click(function(){ jQuery('#carrier_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('carrier_button', $script, CClientScript::POS_READY);
        }

    }

?>
