<?php
/**
 * @var DefaultController $this
 * @var LoginForm $model
 * @var TBActiveForm $form
 */

$this->module->breadcrumbs = array(
    'Авторизация',
);
?>

    <h1>Авторизация</h1>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));

if ($model->hasErrors()) {
    echo $form->errorSummary($model);
}

echo $form->textFieldRow($model, 'username');
echo $form->passwordFieldRow($model, 'password');
echo $form->checkBoxRow($model, 'rememberMe');
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Вход'
));
$this->endWidget();