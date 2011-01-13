<?php


    class CustomerController extends DashController
    {

        public $menu_active = 4;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "客户", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'customer-add',
                        'header' => '添加客户',
                    ),
                    ));
            $model = new customer_entity('search');
            if (isset($_GET['customer_entity']))
            {
                $model->attributes = $_GET['customer_entity'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加客户", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $model=new customer_entity();
            if($_POST['customer'])
            {
                $model->attributes=$_POST['customer'];
                if($model->save())
                {
                        customer_group::addment($model->customer_ID, $_POST['customer_group'],$model->customer_default_group_ID);
                       $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');

            $this->render('create', array('model' => $model,'groups'=>$_POST['customer_group']));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑客户", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
   
             $model=$this->loadModel();
            if($_POST['customer'])
            {
                if($_POST['password'])
                {
                    $model->setPassword($_POST['password']);
                }
                $model->attributes=$_POST['customer'];
                if($model->save())
                {
                        customer_group::updateItem($model->customer_ID, $_POST['customer_group'],$model->customer_default_group_ID);
                       $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            if($_POST['customer_group'])
            {
                $groups=$_POST['customer_group'];
            }
            else
            {
                $groups=customer_group::customerGroups($model->customer_ID);
            }
      
          
            $this->render('update', array('model' => $model,'groups'=>$groups));
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
                    $this->_model = customer_entity::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#customer-add').click(function(){location.href='/dashboard/customer/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#customer_form').submit()})";
                    break;
            }
            Yii::app()->clientScript->registerScript('customer_button', $script, CClientScript::POS_READY);
        }
    }

?>
