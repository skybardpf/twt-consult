<?php
/**
 * Class LogoutAction
 */
class LogoutAction extends CAction
{
    public function run()
    {
        Yii::app()->user->logout();
		$this->controller->redirect($this->controller->module->homeUrl);
    }
}