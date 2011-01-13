<?php

class CategoryController extends Controller
{
    public $layout='column2';
    private $_model;
    public $acc_active=0;

    public function actionIndex()
    {
        $roots=category_entity::rootCategory();
        $this->render('list',array('roots'=>$roots));
    }

    public function actionView()
    {
        $model=$this->loadModel();
        if($model->seo)
        {
            $this->installMeta($model->seo->attributes);
        }
      $criteria=new CDbCriteria(array(
                            'condition'=>'m2.category_ID ='.$model->category_ID,
                            'join'=>'left join {{category_product}} as m2 ON t.product_ID=m2.product_ID',
                            'order'=>'product_update DESC',
            ));
            $view='view';
        $count=product_entity::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->pageSize=20;
        $pages->applyLimit($criteria);
        $dataProvider=new CActiveDataProvider('product_entity', array(
                        'pagination'=>$pages,
                        'criteria'=>$criteria,
        ));
  
        $this->render('view',array('model'=>$model,'dataProvider'=>$dataProvider));
    }

    public function loadModel()
    {
        if($this->_model==null)
        {
         
            if(isset($_GET['category']))
            {
                $this->_model=category_entity::model()->findByAttributes(array('category_SEF'=>$_GET['category']));
            }
            
            if($this->_model==null)
            {
                throw new CHttpException(404,"The requested page does not exist!");
            }
        }
        return $this->_model;
    }

    private function installMeta($meta)
    {
        $cs=Yii::app()->clientScript;
        $cs->registerMetaTag($meta['SEO_description'], 'description');
        $cs->registerMetaTag($meta['SEO_keyword'],'keywords');
    }


}

?>
