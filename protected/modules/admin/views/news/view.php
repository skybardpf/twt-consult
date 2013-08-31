<?php
/**
 * @var NewsController  $this
 * @var News            $model
 */
?>
<?php
$this->module->breadcrumbs = array(
    'Выход' => $this->createUrl('login/logout'),
    'Новости' => $this->createUrl('news/'),
    'Редактирвоание новости',
);
?>
<h4>Новость "<?= CHtml::encode($model->title); ?>"</h4>