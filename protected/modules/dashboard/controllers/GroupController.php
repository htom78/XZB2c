<?php
    class GroupController extends DashController
    {

        public $menu_active = 4;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "客户组", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'group-add',
                        'header' => '添加客户组',
                    ),
                    ));
            $model = new group_entity('search');
            if (isset($_GET['group_entity']))
            {
                $model->attributes = $_GET['group_entity'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加客户组", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));
            $model=new group_entity();
            if($_POST['group'])
            {
                $model->attributes=$_POST['group'];
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
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑客户组", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));

            $model=$this->loadModel();
            if($_POST['group'])
            {
                $model->attributes=$_POST['group'];
                if($model->save())
                {
                   $this->redirect(array('index'));
                }
            }
            $this->constructScript('create');
            $this->render('create', array('model' => $model));
        }

        public function actionView()
        {
              $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑客户组", 'button' => array(
                 
                    ));

            $model=$this->loadModel();
            $customer=new customer_entity();
             if (isset($_GET['customer_entity']))
            {
                $customer->attributes = $_GET['customer_entity'];
            }
            $criteria = new CDbCriteria(array(
                    'condition' => "m1.group_ID={$model->group_ID}",
                    'join'=>' LEFT JOIN tm_customer_group as m1 ON t.customer_ID=m1.customer_ID',
                ));

            $criteria->compare('customer_ID', $customer->customer_ID);
            
            $criteria->compare('customer_email', $customer->customer_email, true);

            $criteria->compare('customer_last_name', $customer->customer_last_name, true);

            $criteria->compare('customer_first_name', $customer->customer_first_name, true);

            $criteria->compare('customer_active', $customer->customer_active);

            $dataProvider=new CActiveDataProvider('customer_entity', array(
			'criteria'=>$criteria,
		));
         
            $this->render('view', array('model' => $model,'dataProvider'=>$dataProvider,'customer'=>$customer));
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
                    $this->_model = group_entity::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#group-add').click(function(){location.href='/dashboard/group/create';});";
                    break;
                case 'create':
                case 'update':
                    $script="jQuery('#form-save').click(function(){ jQuery('#group_form').submit()})";
                    break;
           
            }
            Yii::app()->clientScript->registerScript('group_button', $script, CClientScript::POS_READY);
        }
    }

?>
