<?php
Yii::import('zii.widgets.CListView');

class TradeList extends CListView
{
    public $baseUrl;
    public $cssFile=FALSE;
public function registerClientScript()
	{
	
	}

    public function renderItems()
    {

        $data=$this->dataProvider->getData();
        if(count($data)>0)
        {
            $owner=$this->getOwner();
            $render=$owner instanceof CController ? 'renderPartial' : 'render';
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->$render($this->itemView,$data);
            }
        }
        else
            $this->renderEmptyText();

    }


    public function renderPagination()
    {
        if(!$this->enablePagination)
            return;


        $pager=array();
        $class='TradePager';
        if(is_string($this->pager))
            $class=$this->pager;
        else if(is_array($this->pager))
        {
            $pager=$this->pager;
            if(isset($pager['class']))
            {
                $class=$pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages']=$this->dataProvider->getPagination();
        $pager['baseUrl']=$this->baseUrl;

        $this->widget('TradePager',$pager);
    }

    public function renderEmptyText()
    {
        $emptyText=$this->emptyText===null ? Yii::t('zii','No results found.') : $this->emptyText;
        echo CHtml::tag('div', array('class'=>'pop_box','style'=>'padding: 12px;'), $emptyText);

    }
    

}

?>
