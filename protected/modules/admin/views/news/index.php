<?php
/**
 * @var NewsController  $this
 * @var News[]          $data
 */
?>
<?php
$this->module->breadcrumbs = array(
    'Выход' => $this->createUrl('login/logout'),
    'Новости',
);
?>
<h4>Новости</h4>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type'         => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($data),
    'template'     => "{items}{pager}",
    'columns'      => array(
        array(
            'name' => 'created',
            'header' => 'Дата публикации'
        ),
        array(
            'name' => 'title',
            'header' => 'Заголовок',
            'type' => 'raw',
            'value' => 'CHtml::link($data["title"], Yii::app()->createUrl("admin/news/view", array("id" => $data["id"])))'
        ),
        array(
            'name' => 'display',
            'header' => 'Показывать',
            'value' => '($data["display"] ? "Да" : "Нет")'
        ),
    ),
));