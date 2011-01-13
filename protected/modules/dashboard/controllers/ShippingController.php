<?php

    class ShippingController extends DashController
    {

        public $menu_active = 3;
        public $sideView = 'sidebar/new';
        private $_model;

        public function actionIndex()
        {
            $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "货运设置", 'button' => array(
                     array(
                        'class' => 'scalable save',
                        'id' => 'form-save',
                        'header' => '保存',
                    ),
                ));
            $carrier= $this->loadModel();
          

            if ($_POST['SHIPPING'])
            {
                configuration::updateItems($_POST['SHIPPING']);
            }
            if($_POST['feeAdd'])
            {
               
                foreach ($_POST['feeAdd'] as $key=>$row)
                {
                    if($row!=0)
                    {
                     $arr=explode('-',$key);
                     $delivery=new delivery();
                     $delivery->carrier_ID=$_POST['carrier_ID'];
                     $delivery->zone_ID=$arr[0];
                     $delivery->weight_range_ID=$arr[1];
                     $delivery->price=$row;
                     $delivery->save();
                    }
                }
                
            }
             if($_POST['feeUpdate'])
            {
                foreach ($_POST['feeUpdate'] as $key=>$row)
                {
                   $delivery=delivery::model()->findByPk($key);
                    if($row!=0 && $row!=$delivery->price)
                    {
                     $delivery->price=$row;
                     $delivery->save();
                    }
                    else if($row==0)
                    {
                        $delivery->delete();
                    }
                }
                  
            }
              $config=configuration::item('SHIPPING','SHIPPING_FREE_PRICE');
            $this->constructScript('index');
            $this->render('index', array('config' => $config,'carrier'=>$carrier));
        }


          public function loadModel()
        {
            if ($this->_model == null)
            {
                if (isset($_GET['id']))
                {
                    $condition = '';
                    $this->_model = carrier_entity::model()->findByPk($_GET['id'], $condition);
                }
                else
                {
                     $this->_model = carrier_entity::model()->find('carrier_active=1 AND carrier_deleted=2');
                }
            }
            return $this->_model;
        }
        
        private function constructScript($scenario='index')
        {
            switch ($scenario)
            {
                case 'index':
                    $script = "jQuery('#form-save').click(function(){ jQuery('#shipping_form').submit()})
                               jQuery('#carrier').change(function(){location.href='/dashboard/shipping/index/id/'+this.value;})
";
                    break;
            }
            Yii::app()->clientScript->registerScript('shipping_button', $script, CClientScript::POS_READY);
        }

    }

?>
