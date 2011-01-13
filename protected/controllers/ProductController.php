<?php

class ProductController extends Controller
{

    public $layout = 'column2';
    private $_model;


    public function actionView()
    {
        
        $model = $this->loadModel();
        if ($model->seo)
        {
            $this->installMeta($model->seo->attributes);
        }
        $this->constructScript();
        $this->render('view', array('model' => $model));
    }

  

    public function actionQtyValidate()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            exit();
        }
        $id = $_POST['id'];
        $qty = $_POST['qty'];

        $product = product_entity::model()->findByPk($id);

        if (($qty > $product->stock->stock_max_qty_cart) OR ($qty < $product->stock->stock_min_qty_cart))
        {
            if ($qty > $product->stock->stock_max_qty_cart)
            {
                $qty = $product->stock->stock_max_qty_cart;
            }
            else
            {
                $qty = $product->stock->stock_min_qty_cart;
            }
            if (isset($_POST['record']))
            {
                Yii::app()->cart->update($product, $qty);
                $this->changeDbCart($product->product_ID, $qty);
                Yii::app()->user->setFlash('cart', "This product's quantity must above " . $product->stock->stock_min_qty_cart . " and below " . $product->stock->stock_max_qty_cart);
            }
            echo "fail" . "::" . $qty . "::" . Yii::app()->cart->getCost();
        }
        else
        {
            if (isset($_POST['record']))
            {
                Yii::app()->cart->update($product, $qty);
                $this->changeDbCart($product->product_ID, $qty);
                Yii::app()->user->setFlash('cart', "The product's quantity has been changed!");
            }
            echo "success" . "::" . Yii::app()->cart->getCost();
        }
    }


    public function actionCart()
    {
        $errors='';
        $qty = $_GET['qty'];
   
        $product = $this->loadModel();
        
        if($qty<0 || $qty>100)
        {
            $errors .="Quantity Invalid \n";
        }
        $cart=cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
        if(!$cart)
        {
            //To do
        }
        $cart->updateQty($qty,$product->product_ID);
        Yii::app()->user->setFlash('cart', "Add {$product->product_name} to cart!");
        $this->redirect(array('cart/index'));
    }

    public function loadModel()
    {
        if ($this->_model === null)
        {
            if (isset($_GET['product']))
            {
                $this->_model = product_entity::model()->findByAttributes(array('product_SEF' => $_GET['product']));
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    private function installMeta($meta)
    {
        $cs = Yii::app()->clientScript;
        $cs->registerMetaTag($meta['SEO_description'], 'description');
        $cs->registerMetaTag($meta['SEO_keyword'], 'keywords');
    }
 private function constructScript($scenario='view')
        {
            $cs = Yii::app()->clientScript;
            $script = 'null';
            switch ($scenario)
            {
                case 'view':
                  $script = " $('#product_info').viTab({tabCss : 'i_d_sel',tabScroll : 0,tabEvent :1});
        $('#imgList a').click(function(){ $(this).addClass('p_b_ilsel');$(this).siblings().removeClass('p_b_ilsel');var src=$(this).children('span').html();
        var alt=$(this).children('img').attr('alt');$('#base_img').attr('src',src);$('#base_img_lable').html(alt);return false; });
        $('#add-cart').click(function(){ var qty=$('#product_qty').val();var product=$('#product_SEF').val();location.href='/product/cart/product/'+product+'/qty/'+qty;});
";
                    $cs->registerCoreScript('jquery');
                    $cs->registerScriptFile('/script/tabs.js', CClientScript::POS_HEAD);
                    $cs->registerScript('product_view', $script, CClientScript::POS_READY);
                    break;
            }
        }
}
