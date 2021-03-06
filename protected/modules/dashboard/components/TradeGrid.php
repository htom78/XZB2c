<?php

Yii::import('zii.widgets.grid.CGridView');

class TradeGrid extends CGridView
{

public $filterCssClass='filter';
public $beforeAjaxUpdate='function(id) {$("#loading-mask").show();}';
public $afterAjaxUpdate='function(id,data){$("#loading-mask").hide();}';
public $loadingCssClass=null;



public function renderItems()
{


if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
{
echo "<table class=\"items\">\n";
$this->renderTableHeader();
$this->renderTableFooter();
$this->renderTableBody();
echo "</table>";
}
else
$this->renderEmptyText();
}

public function renderFilter()
{
if($this->filter!==null)
{
echo "<tr class=\"{$this->filterCssClass}\">\n";
foreach($this->columns as $column)
$column->renderFilterCell();
echo "</tr>";
}
}

public function renderTableHeader()
{
if(!$this->hideHeader)
{
echo "<thead>\n";

if($this->filterPosition===self::FILTER_POS_HEADER)
$this->renderFilter();

echo "<tr class='headings'>\n";
$this->renderHeaderCell();
echo "</tr>\n";

if($this->filterPosition===self::FILTER_POS_BODY)
$this->renderFilter();

echo "</thead>\n";
}
else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
{
echo "<thead>\n";
$this->renderFilter();
echo "</thead>\n";
}
}

public function renderTableBody()
{
$data=$this->dataProvider->getData();
$n=count($data);
echo "<tbody>\n";

if($n>0)
{
for($row=0;
$row<$n;
++$row)
$this->renderTableRow($row);
}
else
{
echo '<tr><td colspan="'.count($this->columns) .'">';
$this->renderEmptyText();
echo "</td></tr>\n";
}
echo "</tbody>\n";
}

public function renderTableRow($row)
{

if($this->rowCssClassExpression!==null)
{
$data=$this->dataProvider->data[$row];

echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
}
else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
{
echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
}
else
{
echo '<tr>';
}




foreach($this->columns as $column)
$column->renderDataCell($row);


echo "</tr>\n";
}

public function renderHeaderCell()
{

$controller=Yii::app()->getController();

foreach($this->columns as $i=>$column)
{
echo "<th><span class='nobr'>";


if(isset($column->name))
{
echo $this->createSortLink($controller,$column);

}


echo "</span></th>";
}


}


public function renderAddon()
{
if(($count=$this->dataProvider->getItemCount())<=0)
return $this->renderMassaction();

echo '<table class="actions" cellspacing="0"><tbody><tr><td class="pager">';
if($this->enablePagination)
{
if(($summaryText=$this->summaryText)===null)
$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
$pagination=$this->dataProvider->getPagination();
$start=$pagination->currentPage*$pagination->pageSize+1;
echo strtr($summaryText,array(
'{start}'=>$start,
'{end}'=>$start+$count-1,
'{count}'=>$this->dataProvider->getTotalItemCount(),
));
}
else
{
if(($summaryText=$this->summaryText)===null)
$summaryText=Yii::t('zii','Total {count} result(s).');
echo strtr($summaryText,array('{count}'=>$count));
}
echo "</td>";
echo '<td class="filter-actions a-right">';


echo '</tr></tbody></table>';
$this->renderMassaction();
}

public function renderMassaction()
{
echo '
    <div id="productGrid_massaction">
<table cellspacing="0" cellpadding="0" class="massaction">
<tr><td></td><td></td></tr>
</table>
</div>';

}

public function createSortLink($controller,$column)
{


$csort=$column->grid->dataProvider->getSort();
$sorts=array();
$htmlOptions=array();
$directions=$column->grid->dataProvider->getSort()->getDirections();
if(isset($directions[$column->name]) )
{
$class=$directions[$column->name] ? 'desc' : 'asc';

$htmlOptions['class']='sort-arrow-'. $class;

$descending=!$directions[$column->name];
unset($directions[$column->name]);
}
else
{
$htmlOptions['class']='not-sort';
$descending=false;
}


if($csort->multiSort)
{
$directions=array_merge(array($column->name=>$descending),$directions);
}
else
{
$directions=array($column->name=>$descending);
}



foreach( $directions as $attribute=>$descending)
{
$sorts[]=$descending ? $attribute.$csort->separators[1].$csort->descTag : $attribute;
}

$params=$csort->params===null ? $_GET : $csort->params;

$params[$csort->sortVar]=implode($csort->separators[0],$sorts);


$url=$controller->createUrl($csort->route,$params);




return "<a href='{$this->normalizeUrl($url)}' class='{$htmlOptions['class']}'><span class='sort-title'>{$column->header}</span></a>";

}

function normalizeUrl($url)
{
if(is_array($url))
{
if(isset($url[0]))
{
if(($c=Yii::app()->getController())!==null)
$url=$c->createUrl($url[0],array_splice($url,1));
else
$url=Yii::app()->createUrl($url[0],array_splice($url,1));
}
else
$url='';
}
return $url==='' ? Yii::app()->getRequest()->getUrl() : $url;
}

public function run()
{

$this->registerClientScript();



$this->renderAddon();
echo "<div class='grid'>";
echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

$this->renderKeys();
$this->renderContent();
echo "</div>";
echo CHtml::closeTag($this->tagName);


}

public function renderSummary()
{

}



}