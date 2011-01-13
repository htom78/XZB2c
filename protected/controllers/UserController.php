<?php
class UserController extends Controller
{
    public $layout='column1';
    public function filters()
    {
        return array(
                'accessControl',
        );
    }

    public function accessRules()
    {
        return array(

                array('allow',

                        'users'=>array('@'),
                ),

                array('deny',  // deny all users
                        'users'=>array('*'),
                ),


        );
    }

    public function actionIndex()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());
        $this->render('index',array('customer'=>$customer));
    }

    public function actionAccount()
    {
        $model=new PassForm;
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());

        if(isset($_POST['ajax']) && $_POST['ajax']==='pass-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }


        if(isset($_POST['PassForm']))
        {
            $model->attributes=$_POST['PassForm'];

            if($model->validate())
            {

                $customer->setPassword($model->new_password);
                $model->old_password='';
                $model->new_password='';
                $model->confirm_password='';
            }
        }


        $this->render('account',array('customer'=>$customer,'model'=>$model));
    }

    public function actionAddress()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());
        if($_POST['def'])
        {
            $customer->customer_def_addr_ID=$_POST['def'];
            $customer->save();
        }
        $this->render('address',array('customer'=>$customer));
    }

    public function actionWish()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());

        $script=<<<EOC
         get_flash=function(){\$.post('/user/FlashMessage', function(data){
                         \$('#flash').append('<li class="flash">'+data+'</li>');
                          setTimeout(function(){ \$(".flash").fadeOut("slow"); },3000);
                      })

};
EOC;
        Yii::app()->clientScript->registerScript('wish',$script,CClientScript::POS_END);
        Yii::app()->clientScript->registerScript('wish','get_flash()',CClientScript::POS_READY);
        $this->render('wish',array('customer'=>$customer));
    }

    public function actionWishRemove()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            exit();
        }
        $wish=wish::model()->findByPk($_GET['id']);
        if($wish)
        {
            $wish->delete();

            Yii::app()->user->setFlash('user',"Delete a item from wishlist!");
            echo "Success!";
        }
        else
        {
            echo "Failed!";
        }
    }

    public function actionNewAddress()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());
        $model=new customer_address();
        if($_POST['customer_address'])
        {
            $model->attributes=$_POST['customer_address'];
            $model->address_customer_ID=$customer->customer_ID;
            if($model->save())
            {
                $this->redirect(array('address'));
            }
        }
        $this->render('newAddress',array('model'=>$model));
    }

    public function actionOrder()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());

        $condition="order_customer_ID=".$customer->customer_ID;
        $criteria=new CDbCriteria(array(
                        'condition'=>$condition,
                        'order'=>'order_create_at DESC',

        ));

        $count=sales_order::model()->count($criteria);
        $pages=new CPagination($count);


        $pages->pageSize=10;
        $pages->applyLimit($criteria);


        $dataProvider=new CActiveDataProvider('sales_order', array(
                        'pagination'=>$pages,
                        'criteria'=>$criteria,
        ));

        $this->render('order',array('customer'=>$customer,'dataProvider'=>$dataProvider));
    }

    public function actionViewOrder()
    {
        $customer=customer_entity::model()->findByPk(Yii::app()->user->getId());

        if($order==null)
        {
            if(isset($_GET['id']))
            {
                $condition='order_customer_ID=' .$customer->customer_ID;
                $order=sales_order::model()->findByPk($_GET['id'],$condition);
            }
            if($order==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }



        $this->render('viewOrder',array('customer'=>$customer,'model'=>$order));
    }

    public function actionFlashMessage()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            exit();
        }
        if(Yii::app()->user->hasFlash('user'))
        {
            echo Yii::app()->user->getFlash('user');
        }

    }
}
?>
