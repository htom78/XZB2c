<?php
class CSwfUpload extends CWidget
{
    public $jsHandlerUrl;
    public $postParams=array();
    public $config=array();
    public $swfURL='';
    public $jsURL='';
    public function run()
    {
       
        Yii::app()->clientScript->registerScriptFile($this->jsURL, CClientScript::POS_HEAD);
        if(isset($this->jsHandlerUrl))
        {
            Yii::app()->clientScript->registerScriptFile($this->jsHandlerUrl);
            unset($this->jsHandlerUrl);
        }
        $postParams = array('PHPSESSID'=>session_id());
        if(isset($this->postParams))
        {
            $postParams = array_merge($postParams, $this->postParams);
           
        }
       
        $config = array('post_params'=> $postParams, 'flash_url'=>  $this->swfURL);
        $config = array_merge($config, $this->config);
        $config = CJavaScript::encode($config);
        Yii::app()->getClientScript()->registerScript(__CLASS__, "
		var swfu;
			swfu = new SWFUpload($config);
                ");
    }

}