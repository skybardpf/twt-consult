<?php
class CallbackController extends CMS_Controller
{
    public function actionAdd()
    {
        $this->model()->initValues(array('time_id'));
        parent::actionAdd(null, null, array('created' => date('Y-m-d')));
    }

    public function actionShow()
    {
        $this->model()->initValues(array('time_id'));
        parent::actionShow(null, null);
    }

    public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('time_id'));
        return parent::actionModify();
    }

    public function actionList() {
        $this->listCond = array('order' => array('created' => 'DESC'));
        parent::actionList();
    }
}