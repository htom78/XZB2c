<?php $this->beginContent('//layouts/main'); ?>
<?php if(isset($this->step))
{
    echo  '<div class="shopping-step shopping-step'.$this->step.'"></div>';
}
?>
<?php echo $content; ?>
<?php $this->endContent(); ?>