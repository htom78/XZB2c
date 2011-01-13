<?php

    class SiteController extends Controller
    {

        /**
         * Declares class-based actions.
         */
        public function actions()
        {
            return array(
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha' => array(
                    'class' => 'CCaptchaAction',
                    'backColor' => 0xFFFFFF,
                ),
                // page action renders "static" pages stored under 'protected/views/site/pages'
                // They can be accessed via: index.php?r=site/page&view=FileName
                'page' => array(
                    'class' => 'CViewAction',
                ),
            );
        }

        /**
         * This is the default 'index' action that is invoked
         * when an action is not explicitly requested by users.
         */
        public function actionIndex()
        {

            $this->layout = 'column2';
            $this->constructScript();
            $this->render('index');
        }

        /**
         * This is the action to handle external exceptions.
         */
        public function actionError()
        {
            if ($error = Yii::app()->errorHandler->error)
            {
                if (Yii::app()->request->isAjaxRequest)
                    echo $error['message'];
                else
                    $this->render('error', $error);
            }
        }

        public function actionRegister()
        {
            $this->layout = 'column2';
            $model = new RegisterForm();
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form')
            {

                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['RegisterForm']))
            {
                $model->attributes = $_POST['RegisterForm'];

                if ($model->validate() && $model->register())
                {
                    $this->redirect(array('login'));
                }
            }
            $this->render('register', array('model' => $model));
        }

        public function actionLogin()
        {
            $model = new LoginForm;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['LoginForm']))
            {
                $model->attributes = $_POST['LoginForm'];

                if ($model->validate() && $model->login())
                    $this->redirect(Yii::app()->user->returnUrl);
            }
             $this->layout = 'column2';
            $this->render('login', array('model' => $model));
        }

        /**
         * Logs out the current user and redirect to homepage.
         */
        public function actionLogout()
        {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }

        public function actionChangeCurrency()
        {
            $new_currency = $_POST['id'];
            if ($new_currency AND currency::model()->findByPk($new_currency))
            {
                $cart=cart::model()->findByPk(Yii::app()->user->getState('cart_ID'));
                $cart->cart_currency_ID=$new_currency;
                $cart->save();
                Yii::app()->user->setState('currency_ID', $new_currency);
                Yii::app()->user->updateCookie();
                die(1);
            }
            else
                die(0);
        }

        private function constructScript($scenario='index')
        {
            $cs = Yii::app()->clientScript;
            $script = 'null';
            switch ($scenario)
            {
                case 'index':
                    $script = '$("#i_tabs").viTab({tabCss :"i_d_sel",tabScroll : 0,tabEvent :1});
                      $("#index_banner").viTab({tabTime: 2500,tabField : "ul>li",tabScroll : 1,tabEvent :1,tabCss : "c_b_sel"}); ';
                    $cs->registerCoreScript('jquery');
                    $cs->registerScriptFile('/script/tabs.js', CClientScript::POS_HEAD);
                    $cs->registerScript('index_banner', $script, CClientScript::POS_READY);
                    break;
            }
        }

    }