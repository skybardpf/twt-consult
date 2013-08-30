<?php
class Account_reqController extends CMS_Controller {

    public function actionList($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('bank_id', 'sources'));
        $this->listCond = array('order' => array('id' => 'DESC'));
        $this->page->afterListContent = $this->renderView('req_multy_delete', '../../site/views/cms');
        parent::actionList($tableName, $modelNameorModel, $addData);
    }
    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('bank_id', 'sources', 'currency_id'));
        //$this->page->accounts = $res = $this->model()->getList('accounts', 'cms_account', array('where' => array('accounts.account_req_id' => $this->app->request->id)));
        $fields= $this->model()->getFields('accounts', 'cms_account');
        $this->page->acc_fields = $fields;
        $this->page->acc_titles = $this->model()->getTitles('accounts', 'cms_account');
        $showCond = array('where' => array('accounts.account_req_id' => $this->app->request->id));
        $this->page->acc_data = $acc_data = $this->model()->getList('accounts', $this->model()->getFieldsNames('accounts', 'cms_account'), $showCond);
        $this->page->after_show = $this->renderView('accounts', '/../../site/views/cms');
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }

    public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $misc = array(
            'country_source' => array('where' => array('account_req.id' => $this->app->request->id), 'order' => array('title' => 'asc')),
            'country_receiver' => array('where' => array('account_req.id' => $this->app->request->id), 'order' => array('title' => 'asc'))
        );
        $this->model()->initValues(array('bank_id', 'sources', 'country_source', 'country_receiver'), $misc, true);
        return parent::actionModify();
    }

    public function actionAdd($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('bank_id', 'sources', 'country_source', 'country_receiver'), null, true);
        return parent::actionAdd($tableName, $modelNameorModel, array('created' => date('Y-m-d')));
    }

    public function actionMulty_delete() {
        if(isset($_POST['multiple_items'])) {
            $multiple_items_id = $_POST['multiple_items'];
            $this->model()->Delete('account_req', array('id' => array('IN', $multiple_items_id,'(?li)')));
            header('Location: '.zf::$root_url.'account_req/list/');
        }
    }
}