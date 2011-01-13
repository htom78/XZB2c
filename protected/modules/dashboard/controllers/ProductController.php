<?php

    class ProductController extends DashController
    {

        public $menu_active = 2;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "管理商品", 'button' => array(
                    array(
                        'class' => 'scalable add',
                        'id' => 'product-add',
                        'header' => '添加商品',
                    ),
                    ));


            $model = new product_entity();

            if (isset($_GET['product_entity']))
            {

                $model->attributes = $_GET['product_entity'];
            }
            $this->constructScript();

            $this->render('index', array('model' => $model));
        }

        public function actionCreate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "添加商品", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));


            $product = new product_entity;
            $product->seo = new seo();
            $image = new image_entity();
          
            if (isset($_POST['product']))
            {
                $product->attributes = $_POST['product'];
                $product->seo->attributes = $_POST['seo'];
                $image->attributes = $_POST['image'];
                $product->product_def_category_ID = category_entity::resolveDefCategory($_POST['product']['product_category_ID']);

                if ($product->seo->validate())
                {
                    $product->seo->save();

                    $product->product_SEO_ID = $product->seo->SEO_ID;

                    if ($product->save())
                    {
                        category_product::productAddment($product->product_ID, $_POST['product']['product_category_ID']);
                        $image->image_name = $this->uploadCover();
                        $image->image_cover = 1;
                        $image->image_position = 0;
                        $image->image_product_ID = $product->product_ID;
                        $image->save();
                        $this->redirect(array('index'));
                    }
                }
                $tree = $this->constructCategoryTree($_POST['product']['product_category_ID']);
            }
            if (!isset($tree))
            {
                $tree = $this->constructCategoryTree();
            }
            $this->constructScript('create');
            $this->sideView = 'sidebar/create';
            $this->layout = 'column2';
            $this->render('create', array('model' => $product, 'tree' => $tree, 'image' => $image));
        }

        private function uploadCover()
        {
            $poster = $poster = CUploadedFile::getInstanceByName('poster');
            if ($poster)
            {
                $fileName = md5($poster->getTempName());
                $ext = '.' . $poster->getExtensionName();
                $path = 'media/products/' . $fileName . $ext;
                $middlePath = 'media/products/middle/' . $fileName . $ext;
                $smallPath = 'media/products/small/' . $fileName . $ext;
                $poster->saveAs($path);

                $this->resizeImage($path, $fileName, $poster->getExtensionName());

                $image_name = $fileName . $ext;
            }
            else
            {
                $image_name = 'no_image.jpg';
            }
            return $image_name;
        }

        private function resizeImage($path, $fileName, $ext)
        {
            //small size
            Yii::app()->thumb->setThumbsDirectory('/media/products/small');
            Yii::app()->thumb->load($path)->resize(56, 56)->save($fileName . '.' . $ext, strtoupper($ext));
            //middle size
            Yii::app()->thumb->setThumbsDirectory('/media/products/middle');
            Yii::app()->thumb->load($path)->resize(140, 140)->save($fileName . '.' . $ext, strtoupper($ext));
            //normal size
            Yii::app()->thumb->setThumbsDirectory('/media/products');
            Yii::app()->thumb->load($path)->resize(245, 245)->save($fileName . '.' . $ext, strtoupper($ext));
        }

        public function actionUpdate()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "编辑商品", 'button' => array(
                    array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                    ));

            $product = $this->loadModel();
          
            $image = new image_entity();
            $image->image_product_ID = $product->product_ID;
            $discount=new discount_quantity();
            $discount->product_ID=$product->product_ID;
            if (isset($_POST['product']))
            {
                $product->attributes = $_POST['product'];
              
               $product->product_reducetion_from=$_POST['product']['product_reducetion_from'];
                $product->product_reducetion_to=$_POST['product']['product_reducetion_to'];
                $product->seo->attributes = $_POST['seo'];
                $product->validate();
                $product->product_def_category_ID = category_entity::resolveDefCategory($_POST['product']['product_category_ID']);
             
                if ($product->seo->validate())
                {
                    $product->seo->save();

                    if ($product->save())
                    {
                        //process image stuffer
                        if ($_POST['image'])
                        {
                            foreach ($_POST['image'] as $key => $row)
                            {
                                $imageModel = image_entity::model()->findByPk($key);
                                $imageModel->image_legend = $row['legend'];
                                $imageModel->image_position = $row['position'];
                                $imageModel->update();
                            }
                        }
                        category_product::productAlert($product->product_ID, $_POST['product']['product_category_ID']);
                        $this->redirect(array('index'));
                    }
                }
                $tree = $this->constructCategoryTree($_POST['product']['product_category_ID']);
            }


            if (!isset($tree))
            {
                $tree = $this->constructCategoryTree(category_product::getCategoryIDS($product->product_ID));
            }
            if (!isset($_POST['product']['product_status']))
            {
                $status = product_entity::resovelProductStatus($product->product_status);
            }
            else
            {
                $status = $_POST['product']['product_status'];
            }
            $this->constructScript('update');
            $this->sideView = 'sidebar/update';
            $this->layout = 'column2';
            $this->render('update', array('model' => $product, 'tree' => $tree, 'image' => $image, 'status' => $status,'discount'=>$discount));
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

        public function actionUpdateImageCover()
        {
            $cover_ID = image_entity::productCover($_POST['product_ID']);
            if ($_POST['id'] != $cover_ID)
            {
                image_entity::updateProductCover($cover_ID, $_POST['id']);
            }
            echo $cover_ID;
        }
        public function actionAddDiscount()
        {
                if(!discount_quantity::model()->findByAttributes(array('quantity'=>$_POST['discount']['quantity'],'product_ID'=>$_POST['discount']['product_ID'])))
                {
               $discount=new discount_quantity();
               $discount->attributes=$_POST['discount'];
               echo $discount->save();
                }
              
        }
        public function actionDiscountDelete()
        {
             if (Yii::app()->request->isPostRequest)
            {

                if (isset($_GET['id']))
                {

                    $model=discount_quantity::model()->findByPk($_GET['id']);
                }
                if ($model == null)
                {
                    throw new CHttpException(404, "The requested page does not exist!");
                }
                $model->delete();
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
                    $this->_model = product_entity::model()->findByPk($_GET['id'], $condition);
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
                    $script = "$('#product-add').click(function(){location.href='/dashboard/product/create';});";
                    break;
                case 'create':
                    $script = "jQuery('#product_reducetion_to').datepicker({'showAnim':'fold','dateFormat':'yy-mm-dd'});jQuery('#form-save').click(function(){ jQuery('#product_form').submit()})";
                    break;
                case 'update':
                    $script = "jQuery('#product_reducetion_to').datepicker({'showAnim':'fold','dateFormat':'yy-mm-dd'});jQuery('#form-save').click(function(){ jQuery('#product_form').submit()})
                        updateCover=function(id,product_ID)
                        {
                          $.post('/dashboard/product/updateImageCover', { 'id':id ,'product_ID':product_ID},function(data){ $.fn.yiiGridView.update('yw0');});
                        }
 jQuery('#discount_save').live('click',function(){
 jQuery.ajax({
 'type':'POST',
 'url':'/dashboard/product/addDiscount',
 'cache':false,
 'data':jQuery(this).parents('form').serialize(),
  'success':function(data){ $.fn.yiiGridView.update('yw2');}
  });
 return false;
 });
";
                    break;
            }
            Yii::app()->clientScript->registerScript('product_button', $script, CClientScript::POS_READY);
        }

        private function PackageTree($category, $def_IDS)
        {
            $expanded = false;
            $checked = '';

            if ($def_IDS != null)
            {
                foreach ($def_IDS as $ID)
                {

                    if ($category['category_ID'] === $ID)
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
                    'text' => "<input  name='product[product_category_ID][]' {$checked} type='checkbox' value='{$category['category_ID']}' />{$category['category_name']}",
                    'expanded' => $expanded,
                    'hasChildren' => true,
                    'children' => $begats,
                );
            }
            else
            {
                $node = array(
                    'text' => "<input  name='product[product_category_ID][]' {$checked} type='checkbox' value='{$category['category_ID']}' /> {$category['category_name']}",
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

        public function actionUpload()
        {

            if (isset($_FILES['Filedata']))
            {
                $filedata = $_FILES['Filedata'];
                parse_str($_POST['PHPSESSID'], $temp);
                $product_ID = $temp['product_ID'];

                if (($pos = strrpos($filedata['name'], '.')) !== false)
                    $ext = (string) substr($filedata['name'], $pos + 1);
                else
                    $ext='';

                $file_name = md5($_FILES['Filedata']['tmp_name']);

                $path = 'media/products/' . $file_name . '.' . $ext;

                @move_uploaded_file($filedata['tmp_name'], $path);
                $this->resizeImage($path, $file_name, $ext);

                $image = new image_entity();
                $image->image_name = $file_name . '.' . $ext;
                $image->image_cover = 0;
                $image->image_product_ID = $product_ID;
                $image->image_position = 0;
                $image->save();
                echo 'FILEID:' . $image->image_name;
            }
        }

        public function actionImageDelete()
        {
            if (Yii::app()->request->isPostRequest)
            {
                if (isset($_GET['id']))
                {
                    $image = image_entity::model()->findByPk($_GET['id']);
                }
                $image->delete();
                $this->redirect(array('index'));
            }
            else
                throw new CHttpException(400, 'Invalid request...');
        }

    }

?>