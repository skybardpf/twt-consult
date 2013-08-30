<?php
class Entity_reqController extends CMS_Controller {

    public function actionList($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('jur_country_id', 'kind_activities', 'currency_id'), null, true);
        $this->listCond = array('order' => array('id' => 'DESC'));
        $this->page->afterListContent = $this->renderView('req_multy_delete', '../../site/views/cms');
        parent::actionList($tableName, $modelNameorModel, $addData);
    }
    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('jur_country_id', 'kind_activities', 'currency_id'), null, true);
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }

    public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $misc = array(
            'country_source' => array('where' => array('entity_req.id' => $this->app->request->id), 'order' => array('title' => 'asc')),
            'country_receiver' => array('where' => array('entity_req.id' => $this->app->request->id), 'order' => array('title' => 'asc'))
        );
        $this->model()->initValues(array('jur_country_id', 'kind_activities', 'currency_id', 'country_source', 'country_receiver'), $misc, true);
        return parent::actionModify();
    }

    public function actionAdd($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('jur_country_id', 'kind_activities', 'currency_id', 'country_source', 'country_receiver'), null, true);
        return parent::actionAdd($tableName, $modelNameorModel, array('created' => date('Y-m-d')));
    }

    public function actionMulty_delete() {
        if(isset($_POST['multiple_items'])) {
            $multiple_items_id = $_POST['multiple_items'];
            $this->model()->Delete('entity_req', array('id' => array('IN', $multiple_items_id,'(?li)')));
            header('Location: '.zf::$root_url.'entity_req/list/');
        }
    }

}