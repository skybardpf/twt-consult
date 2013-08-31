<?php
/**
 * @var string $content
 */

Yii::app()->bootstrap->register();
Yii::app()->clientScript->registerCssFile($this->module->baseAssets.'/css/main.css');
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $this->pageTitle; ?></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
</head>

<body>

<div class="container-narrow wrapper" id="page">
    <div id="header">
        <?php
        if(isset($this->module->breadcrumbs)) {
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                'links'=>$this->module->breadcrumbs,
                'homeLink'=> CHtml::link('Главная', $this->createAbsoluteUrl('/admin/'))
            ));
        }
        ?>
    </div><!-- header -->

    <?= $content; ?>

</div><!-- page -->
<div id="footer" class="container-narrow">
</div><!-- footer -->
</body>
</html>