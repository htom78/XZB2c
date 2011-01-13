<?php
    $this->pageTitle = $model->seo->SEO_title;

    $tree = $model->getFamliyTree();
?>
<div id="navigate">
        <a href="/" class="n_home">Home</a>
    <?php
        if ($tree)
        {
            foreach ($tree as $key => $item)
            {
                echo " - <a href='/{$item['category_SEF']}'>{$item['category_name']}</a> - ";
            }
        }
    ?>
        <span><?php echo $model->category_name; ?></span>
        <span class="n_icol"></span>
        <span class="n_icor"></span>
</div>

<div class="content_box mb_12">

    <?php
        foreach ($model->getSibling() as $row)
        {
            $relate.="<a href='/{$row['category_SEF']}'>{$row['category_name']}</a>&nbsp;&nbsp;&nbsp;";
        }
        $relate = rtrim($relate);
    ?>
    <?php
        echo " <div class='pop_box' style='padding:12px;'>
          <h2 class='p_c_ctitle'>{$model->category_name}</h2>
          <div class='p_c_intr'>
            <h1>{$model->seo->SEO_title}</h1>
            <p>{$model->category_description}</p>
            <div class='p_rellinks'>Relate Categories:{$relate}</div>
          </div>
      <div class='fix'></div>
    </div>";

        $this->widget('TradeList', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
            'template' => "<div class='content_box mb_12 prduct_list'>{items}</div>
    <div class='pop_box' style='padding:18px 12px;'>{pagination}</div><div class='fix'></div>",
     'baseUrl' => '/' . $model->category_SEF,
        ));
    ?>
</div>
