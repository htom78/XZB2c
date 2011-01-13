<?php

    class CurrencyController extends DashController
    {

        public $menu_active = 5;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "汇率管理", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'currency-add',
                        'header' => '添加货币',
                    ),
                    array(
                        'class' => 'scalabel add',
                        'id' => 'currency-refresh',
                        'header' => '更新汇率',
                    )
                ));
            $model = new currency();
            if (isset($_GET['currency']))
            {
                $model->attributes = $_GET['currency'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加币种", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model = new currency();
            if ($_POST['currency'])
            {
                $model->attributes = $_POST['currency'];
                if ($model->save())
                {
                    $this->redirect(array('index'));
                }
            }

            $this->constructScript('create');
            $this->render('create', array('model' => $model));
        }


          public function actionUpdate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑币种", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model = $this->loadModel();
            if ($_POST['currency'])
            {
                $model->attributes = $_POST['currency'];
                if ($model->save())
                {
                    $this->redirect(array('index'));
                }
            }

            $this->constructScript('update');
            $this->render('create', array('model' => $model));
        }
        public function actionRefresh()
        {
            currency::refreshCurrencies();
            $this->redirect(array('index'));
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
                    $this->_model = currency::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#currency-add').click(function(){location.href='/dashboard/currency/create';});$('#currency-refresh').click(function(){location.href='/dashboard/currency/refresh';});";
                    break;
                case 'create':
                case 'update':
                    $script = "jQuery('#form-save').click(function(){ jQuery('#currency_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('address_button', $script, CClientScript::POS_READY);
        }

    }

?>
