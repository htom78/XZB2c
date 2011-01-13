<?php

    class CouponController extends DashController
    {

        public $menu_active = 1;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "优惠券", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'coupon-add',
                        'header' => '新建优惠券',
                    ),
                ));
            $model = new discount_entity('search');
            if (isset($_GET['discount_entity']))
            {
                $model->attributes = $_GET['discount_entity'];
            }
            $this->constructScript();
            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {

            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "新建优惠券", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model = new discount_entity();
            if ($_POST['discount'])
            {
                $model->attributes = $_POST['discount'];
                $model->discount_customer_email = $_POST['discount']['discount_customer_email'];
                if ($customer = customer_entity::model()->findByAttributes(array('customer_email' => $model->discount_customer_email)))
                {
                    $model->discount_customer_ID = $customer->customer_ID;
                }
                else
                {
                    $model->discount_customer_ID = 0;
                }
                if ($model->save())
                {
                    discount_category::AddItem($model->discount_ID,$_POST['discount']['discount_category_ID']);
                    $this->redirect(array('index'));
                }

                $tree = $this->constructCategoryTree($_POST['discount']['discount_category_ID']);
            }
            if (!isset($tree))
            {
                $tree = $this->constructCategoryTree();
            }
            $this->constructScript('create');
            $this->render('create', array('model' => $model, 'tree' => $tree));
        }

        public function actionUpdate()
        {
             $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑优惠券", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $model =$this->loadModel();
            if($model->discount_customer_ID!==0)
            {
                $model->discount_customer_email=customer_entity::model()->findByPk($model->discount_customer_ID)->customer_email;
            }
            if ($_POST['discount'])
            {
                $model->attributes = $_POST['discount'];
                $model->discount_customer_email = $_POST['discount']['discount_customer_email'];
                if ($customer = customer_entity::model()->findByAttributes(array('customer_email' => $model->discount_customer_email)))
                {
                    $model->discount_customer_ID = $customer->customer_ID;
                }
                else
                {
                    $model->discount_customer_ID = 0;
                }
                if ($model->save())
                {
                    discount_category::updateItem($model->discount_ID,$_POST['discount']['discount_category_ID']);
                    $this->redirect(array('index'));
                }

                $tree = $this->constructCategoryTree($_POST['discount']['discount_category_ID']);
            }
            if (!isset($tree))
            {
                $tree = $this->constructCategoryTree(discount_category::items($model->discount_ID));
            }
            $this->constructScript('update');
            $this->render('update', array('model' => $model, 'tree' => $tree));
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
                    $this->_model = discount_entity::model()->findByPk($_GET['id'], $condition);
                }
                if ($this->_model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }
            return $this->_model;
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

        private function PackageTree($category, $def_IDS)
        {
            $expanded = false;
            $checked = '';

            if ($def_IDS != null)
            {
                foreach ($def_IDS as $ID)
                {

                    if ($category['category_ID'] == $ID)
                    {
                        $checked = 'checked="true"';
                        $expanded = true;
                    }
                }
            }


            if ($children = category_entity::getChirdren($category['category_ID']))
            {
                foreach ($children as $key => $row)
                {
                    $begats[] = $this->PackageTree($row, $def_IDS);
                    if ($begats[$key]['expanded'])//延展上溯至父类
                    {
                        $expanded = true;
                    }
                }
                $node = array(
                    'text' => "<input  name='discount[discount_category_ID][]' {$checked} type='checkbox' value='{$category['category_ID']}' />{$category['category_name']}",
                    'expanded' => $expanded,
                    'hasChildren' => true,
                    'children' => $begats,
                );
            }
            else
            {
                $node = array(
                    'text' => "<input  name='discount[discount_category_ID][]' {$checked} type='checkbox' value='{$category['category_ID']}' /> {$category['category_name']}",
                    'expanded' => $expanded
                );
            }

            return $node;
        }

        public function constructCategoryTree($checked_IDS=null)
        {
            $roots = category_entity::rootCategory();
            foreach ($roots as $row)
            {
                $tree[] = $this->PackageTree($row, $checked_IDS);
            }
            return $tree;
        }

        private function constructScript($scenario='index')
        {
            switch ($scenario)
            {
                case 'index':
                    $script = "$('#coupon-add').click(function(){location.href='/dashboard/coupon/create';});";
                    break;
                case 'create':
                     $script = "jQuery('#discount_to').datepicker({'showAnim':'fold','dateFormat':'yy-mm-dd'});jQuery('#form-save').click(function(){ jQuery('#coupon_form').submit()});";
                    break;
                case 'update':
                    $script = "jQuery('#discount_to').datepicker({'showAnim':'fold','dateFormat':'yy-mm-dd'});jQuery('#form-save').click(function(){ jQuery('#coupon_form').submit()});$('#type').trigger('change');";
                    break;
            }
            Yii::app()->clientScript->registerScript('coupon_button', $script, CClientScript::POS_READY);
        }

    }

?>
