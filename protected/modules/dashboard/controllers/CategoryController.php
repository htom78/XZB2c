<?php

    class CategoryController extends DashController
    {

        public $menu_active = 2;
        public $sideView = 'sidebar/index';
        public $product;
        private $_model;

        public function actionIndex()
        {
            $this->redirect(array('update'));
        }

        public function actionUpdate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "管理分类", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'category-save',
                        'header' => '保存编辑',
                    ),
                    array(
                        'class' => 'scalable delete',
                        'id' => 'category-delete',
                        'header' => '删除',
                    ),
                    array(
                        'class' => 'scalable',
                        'id' => 'sort_subcategory_button',
                        'header' => '所属分类排序',
                    ),
                    ));

           

            $category = $this->loadModel();

            if (isset($_POST['category']))
            {

                $category->attributes = $_POST['category'];
                $category->seo->attributes = $_POST['seo'];

                if ($category->validate() && $category->seo->validate())
                {
                    $category->save();
                    $category->seo->save();
                  $this->redirect(array('index'));
                }
            
            }
            $this->constructScript();
            $this->sideView = 'sidebar/index';
            $this->sideData=array('tree'=>$this->constructCategoryTree($category->category_ID));
            $this->layout = 'column2';
            $this->render('index', array('model' => $category,'tree'=>$tree));
        }

        public function loadModel($pk=1)
        {
            if (isset($_GET['id']))
            {
                $pk = $_GET['id'];
            }
            if ($this->_model == null)
            {
                if (isset($pk))
                {
                    $condition = '';
                    $this->_model = category_entity::model()->findByPk($pk, $condition);
                }
                if ($this->_model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
            }
            return $this->_model;
        }

        public function actionCreate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "新建分类", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'category-save',
                        'header' => '保存',
                    ),
                    ));
          
            $category = new category_entity();
            $category->seo = new seo();

            if (isset($_GET['parent']))
            {
                $category->category_parent_ID = $_GET['parent'];
            }

            if (isset($_POST['category']))
            {

                $category->seo->attributes = $_POST['seo'];
                $category->attributes = $_POST['category'];
                if ($category->seo->save())
                {
                    $category->category_SEO_ID = $category->seo->SEO_ID;
                    if (isset($_POST['category']['category_parent_ID']) && $_POST['category']['category_parent_ID'] != null)//subcategory
                    {
                        $parent = category_entity::model()->findByPk($category->category_parent_ID);
                        $category->category_level = $parent->category_level + 1;
                        $category->category_path = $parent->category_path . ',' . $parent->category_ID;
                    }
                    else
                    {
                        $category->category_parent_ID = 0;
                        $category->category_level = 1;
                        $category->category_path = 0;
                    }
                    if ($category->save())
                    {
                        $this->redirect(array('update'));
                    }
                }
            }
            $this->constructScript();

           $this->sideView = 'sidebar/index';
           $this->layout = 'column2';
           $this->sideData=array('tree'=>$this->constructCategoryTree($_GET['parent']));
           $this->render('index', array('model' => $category));
        }

        private function constructScript()
        {

            $script = "
        $('#add_root_category_button').click(function(){
            location.href='/dashboard/category/create/';
});

 $('#add_subcategory_button').click(function(){
      var parent=$('#category_ID').val();
      location.href='/dashboard/category/create/parent/'+parent;
});

$('#category-delete').click(function(){
     var ID=$('#category_ID').val();
    location.href='/dashboard/category/delete/id/'+ID;
});
$('#sort_subcategory_button').click(function(){
     var ID=$('#category_ID').val();
    location.href='/dashboard/category/order/id/'+ID;
});
$('#sort_rootcategory_button').click(function(){
     var ID=$('#category_ID').val();
    location.href='/dashboard/category/order';
});
$('#category-save').click(function(){
    $('#category_form').submit();
});
";
            Yii::app()->clientScript->registerScript('category_button', $script, CClientScript::POS_READY);
        }

        public function actionDelete()
        {
            $this->loadModel()->delete();
            $this->redirect(array('index'));
        }

        public function actionOrder()
        {
            if (Yii::app()->request->isPostRequest && isset($_POST['Order']))
            {

                $models = explode(',', $_POST['Order']);

                for ($i = 0; $i < sizeof($models); $i++)
                {
                    if ($model = category_entity::model()->findbyPk($models[$i]))
                    {
                        $model->category_order = $i;

                        $model->save();
                    }
                }
            }
            else
            {
                if ($_GET['id'])
                {
                    $condition = "category_parent_ID={$_GET['id']}";
                }
                else
                {
                    //root category sort
                    $condition = "category_level=1";
                }
                $dataProvider = new CActiveDataProvider('category_entity', array(
                            'pagination' => false,
                            'criteria' => array(
                                'condition' => $condition,
                                'order' => 'category_order ASC, category_ID DESC',
                            ),
                        ));
                $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "分类排序", 'button' => array(
                        ));
                $this->render('order', array('dataProvider' => $dataProvider));
            }
        }

        private function PackageTree($category, $def_ID)
        {
           
            if ($category['category_ID'] == $def_ID)
            {
                $checked ="<img src='{$this->module->registerImage('fam_bullet_success.gif')}' alt='success' />";
                $expanded = true;
            }
            else
            {
                $expanded = false;
                $checked = '';
            }


            if ($children = category_entity::getChirdren($category['category_ID']))
            {
                foreach ($children as $key => $row)
                {
                    $begats[] = $this->PackageTree($row, $def_ID);
                    if ($begats[$key]['expanded'])//延展上溯至父类
                    {
                        $expanded = true;
                    }
                }
                $node = array(
                    'text' => "id:{$category['category_ID']}<a href='/dashboard/category/update/id/{$category['category_ID']}'>{$category['category_name']}</a>{$checked}",
                    'expanded' => $expanded,
                    'hasChildren' => true,
                    'children' => $begats,
                );
            }
            else
            {
                $node = array(
                       'text' => "id:{$category['category_ID']}<a href='/dashboard/category/update/id/{$category['category_ID']}'>{$category['category_name']}</a>{$checked}",
                    'expanded' => $expanded
                );
            }
            return $node;
        }

        public function constructCategoryTree($checked_ID=null)
        {

            $roots = category_entity::rootCategory();
         
            foreach ($roots as $row)
            {
                $tree[] = $this->PackageTree($row, $checked_ID);
            }
            return $tree;
        }
    }

?>
