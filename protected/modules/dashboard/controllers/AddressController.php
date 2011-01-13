<?php

    class AddressController extends DashController
    {

        public $menu_active = 4;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "客户地址", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'address-add',
                        'header' => '添加客户地址',
                    ),
                ));
            $model = new address_entity('search');
            if (isset($_GET['address_entity']))
            {
                $model->attributes = $_GET['address_entity'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCustomerEmail()
        {
            if (isset($_GET['q']) && ($keyword = trim($_GET['q'])) !== '')
            {
                $email = customer_entity::model()->suggestEmail($keyword);
                if ($email !== array())
                    echo implode("\n", $email);
            }
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加客户地址", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model = new address_entity();
            if ($_POST['address'])
            {
                $model->attributes = $_POST['address'];
                $model->address_customer_email = $_POST['address']['address_customer_email'];
                if ($customer = customer_entity::model()->findByAttributes(array('customer_email' => $model->address_customer_email)))
                {
                    $model->address_customer_ID=$customer->customer_ID;
                    if ($model->save())
                    {
                        $this->redirect(array('index'));
                    }
                }
            }
      
            $this->constructScript('create');
            $this->render('create', array('model' => $model));
        }

        public function actionUpdate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑客户地址", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model = $this->loadModel();
            if ($_POST['address'])
            {
                $model->attributes = $_POST['address'];
                if ($model->save())
                 {
                        $this->redirect(array('index'));
                 }
                
            }

            $this->constructScript('update');
            $this->render('update', array('model' => $model));
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
                    $this->_model = address_entity::model()->findByPk($_GET['id'], $condition);
                }
                if ($this->_model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }
            return $this->_model;
        }

        public function actionAjaxState()
        {
            $country = country::model()->findByPk($_POST['address']['address_country_ID']);
            if ($country && $country->contain_states == 1)
            {
                echo CHtml::dropDownList('address[address_state_ID]', '', state::items($country->country_ID), array('id' => 'state'));
            }
            else
            {
                echo CHtml::dropDownList('address[address_state_ID]', '', array(0 => '----------------------------------------'), array('id' => 'state'));
            }
        }

        private function constructScript($scenario='index')
        {
            switch ($scenario)
            {
                case 'index':
                    $script = "$('#address-add').click(function(){location.href='/dashboard/address/create';});";
                    break;
                case 'create':
                case 'update':
                    $script = "jQuery('#form-save').click(function(){ jQuery('#address_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('address_button', $script, CClientScript::POS_READY);
        }

    }

?>
