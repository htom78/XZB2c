<?php

    class CartController extends Controller
    {

        public function actionIndex()
        {
            $cart=cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
            $this->layout = 'column1';
            $this->constructScript();
           
            $this->render('index',array('cart'=>$cart));

        }

        public function actionQuantity()
        {
              $cart=cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
             if($_GET['product'] && $_GET['op'])
            {
                if($_GET['op']=='remove'){
                     $cart->updateQty(0,$_GET['product'],$_GET['op']);
                }else{
                 $cart->updateQty(1,$_GET['product'],$_GET['op']);
                }
            }
            $this->redirect(array('index'));
        }

        public function actionCoupon()
        {
            if($_GET['remove'] && !empty($_GET['remove']))
            {
                cart_discount::model()->deleteAllByAttributes(array('discount_ID'=>$_GET['remove'],'cart_ID'=>Yii::app()->user->getState('cart_ID')));
                Yii::app()->user->setFlash('cart', "voucher has been removed");
                $this->redirect(array('index'));
                exit();
            }
            if($_POST['token']!=md5(Yii::app()->user->getStateKeyPrefix()))
            {
                $this->redirect(array('index'));
                exit();
            }

            if(!$_POST['code'] OR empty ($_POST['code']))
            {
                Yii::app()->user->setFlash('cart', "voucher name can't be blank");
                $this->redirect(array('index'));
                exit();
            }
            if(!$discount=discount_entity::model()->findByAttributes(array('discount_name'=>$_POST['code'])))
            {
                 Yii::app()->user->setFlash('cart', "voucher name not valid");
                  $this->redirect(array('index'));
                  exit();
            }
            $cart=cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
            if($msg=$cart->validateDiscount($_POST['total'],$discount->discount_ID,true))
            {
                 Yii::app()->user->setFlash('cart', $msg);
                  $this->redirect(array('index'));
                  exit();
            }
            else{
            $cartDiscount=new cart_discount();
            $cartDiscount->cart_ID=$cart->cart_ID;
            $cartDiscount->discount_ID=$discount->discount_ID;
            $cartDiscount->save();
            }
            $this->redirect(array('index'));
        }

        private function constructScript($scenario='index')
        {
            $cs = Yii::app()->clientScript;
            $script = 'null';
            switch ($scenario)
            {
                case 'index':
                    $script_ready = "$('#check_btn').click(function(){location.href='/check';});
                        function setCurrency(id){ $.ajax({type: 'POST',url: '/site/changecurrency',data: 'id='+id,success: function(msg){location.reload(true);}});}
                        $('#currency').change(function(){setCurrency(this.value)})";
                    $cs->registerCoreScript('jquery');
                    $cs->registerScript('cart-ready', $script_ready, CClientScript::POS_READY);
                    break;
            }
        }

    }

?>
