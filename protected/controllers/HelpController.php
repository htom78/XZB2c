<?php
class HelpController extends Controller
{


    public $layout='column2';

    public function  __construct($id, $module)
    {

        parent::__construct($id, $module);
         Yii::app()->getClientScript()->registerCoreScript('jquery');
    }

    public function actionIndex()
    {

        $this->redirect(array('about'));
    }

    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionContact()
    {
        $this->render('contact');
    }

    public function actionShipping()
    {
        $this->render('shipping');
    }

    public function actionReturn()
    {
        $this->render('return');
    }

    public function actionPrivacy()
    {
        $this->render('privacy');
    }

    public function actionTerms()
    {
        $this->render('terms');
    }

    public function actionGuide()
    {
        $this->layout='column1';
        $this->render('guide');
    }

}

?>
