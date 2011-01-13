<?php


    class WeightRangeController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "范围", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'weight-add',
                        'header' => '添加范围',
                    ),
                    ));
            $model = new weight_range('search');
            if (isset($_GET['weight_range']))
            {
                $model->attributes = $_GET['weight'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加范围", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $model=new weight_range();
            if($_POST['weight'])
            {
                $model->attributes=$_POST['weight'];
                if($model->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->render('create', array('model' => $model));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑范围", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $model=$this->loadModel();
            if($_POST['weight'])
            {
                $model->attributes=$_POST['weight'];
                if($model->save())
                {
                    $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->render('create', array('model' => $model));
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
                    $this->_model = weight_range::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#weight-add').click(function(){location.href='/dashboard/weightrange/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#weight_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('weight_button', $script, CClientScript::POS_READY);
        }
    }

?>
