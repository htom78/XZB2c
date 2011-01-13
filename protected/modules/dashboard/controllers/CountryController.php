<?php


    class CountryController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "国家", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'country-add',
                        'header' => '添加国家',
                    ),
                    ));
            $model = new country('search');
            if (isset($_GET['country']))
            {
                $model->attributes = $_GET['country'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加国家", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
           $country=new country();
          if($_POST['country'])
            {
                $country->attributes=$_POST['country'];
                if($country->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $country));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑国家", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
           $country=$this->loadModel();
            if($_POST['country'])
            {
                $country->attributes=$_POST['country'];
                if($country->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $country));
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
                    $this->_model = country::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#country-add').click(function(){location.href='/dashboard/country/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#country_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('country_button', $script, CClientScript::POS_READY);
        }
    }

?>
