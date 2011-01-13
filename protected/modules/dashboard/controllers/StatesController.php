<?php


    class StatesController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "州", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'states-add',
                        'header' => '添加州',
                    ),
                    ));
            $model = new state('search');
            if (isset($_GET['state']))
            {
                $model->attributes = $_GET['state'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加州", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $states=new state();
            if($_POST['state'])
            {
                $states->attributes=$_POST['state'];
                if($states->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $states));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑州", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
           $states=$this->loadModel();
            if($_POST['state'])
            {
                $states->attributes=$_POST['state'];
                if($states->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $states));
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
                    $this->_model = state::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#states-add').click(function(){location.href='/dashboard/states/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#states_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('states_button', $script, CClientScript::POS_READY);
        }
    }

?>
