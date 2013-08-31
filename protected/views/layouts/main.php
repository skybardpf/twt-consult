<?php
Yii::app()->clientScript->registerCoreScript('jquery');

Yii::app()->clientScript->registerCssFile($this->baseAssets.'/css/main.css');
Yii::app()->clientScript->registerCssFile($this->baseAssets.'/css/handheld.css');
Yii::app()->clientScript->registerCssFile($this->baseAssets.'/css/jquery-ui.css');
Yii::app()->clientScript->registerCssFile($this->baseAssets.'/css/jquery.pnotify.css');
Yii::app()->clientScript->registerCssFile($this->baseAssets.'/css/jquery-ui-1.9.1.custom.css');
Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Ubuntu:500&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic');

//Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css' );
Yii::app()->clientScript->registerScriptFile($this->baseAssets.'/js/common.js');
Yii::app()->clientScript->registerScriptFile($this->baseAssets.'/js/jquery.pnotify.js');
Yii::app()->clientScript->registerScriptFile($this->baseAssets.'/js/jquery-ui-1.9.1.custom.js');
Yii::app()->clientScript->registerScriptFile($this->baseAssets.'/js/iflabel.js');

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ЗАО «ТВТ консалт»: сопровождение ВЭД. Услуги по организации ВЭД</title>
    <meta name="keywords"
          content="сопровождение вэд, регистрация интеллектуальной собственности, услуги вэд, регистрация компаний за рубежом, вэд услуги, регистрация компаний, организация вэд, открыть оффшорную компанию, консалтинг вэд">
    <meta name="description"
          content="Организация ВЭД. Услуги по сопровождению ВЭД, а также услуги таможенного оформления грузов, международное налоговое планирование, регистрация иностранных компаний, таможенное оформление ВЭД">
    <meta name='yandex-verification' content='5bf43eeeee5bbad8'/>

</head>

<body>

<div class="wrapper_outer">
<div class="wrapper_inner">

<div class="header main">
<?php
    $this->renderPartial('/layouts/header');
?>
</div>

<div class="content">

<?= $content; ?>

<div class="footer">
<?php
    $this->renderPartial('/layouts/footer');
?>
</div>

</div>
</div>

</body>
</html>