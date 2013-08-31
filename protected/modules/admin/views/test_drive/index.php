<?php
/**
 * @var Test_driveController $this
 * @var TestDrive[] $data
 */
?>
<?php
$this->module->breadcrumbs = array(
    'Выход' => $this->createUrl('login/logout'),
    'Заявки на тест-драйв',
);
?>
<h4>Заявки на тест-драйв</h4>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type'         => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($data),
    'template'     => "{items}{pager}",
    'columns'      => array(
        array(
            'name' => 'created',
            'header' => 'Дата создания'
        ),
        array(
            'name' => 'surname',
            'header' => 'Фамилия',
        ),
        array(
            'name' => 'name',
            'header' => 'Имя',
        ),
        array(
            'name' => 'patronymic',
            'header' => 'Отчество',
        ),
        array(
            'name' => 'age',
            'header' => 'Возраст'
        ),
        array(
            'name' => 'city',
            'header' => 'Город'
        ),
        array(
            'name' => 'start_time',
            'header' => 'Начало'
        ),
        array(
            'name' => 'end_time',
            'header' => 'Окончание'
        ),
        array(
            'name' => 'phone',
            'header' => 'Телефон'
        ),
        array(
            'name' => 'email',
            'header' => 'E-mail'
        ),
    ),
));