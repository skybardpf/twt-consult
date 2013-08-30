<?php
class Transport_reqController extends CMS_Controller {

    public function actionList($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('currency'), array('currency' => array('keyField' => 'id')));
        $this->listCond = array('order' => array('id' => 'DESC'));
        $this->page->afterListContent = $this->renderView('req_multy_delete', '../../site/views/cms');
        parent::actionList($tableName, $modelNameorModel, $addData);
    }
    public function actionAdd($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('loading_country', 'delivery_country', 'currency', 'services'), null, true);
        return parent::actionAdd($tableName, $modelNameorModel, array('created' => date('Y-m-d')));
    }

    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('loading_country', 'delivery_country'), null, true);
        $showCond = array('where' => array('transport_req_id' => $this->app->request->id));
        $this->page->loading_fields = $this->model()->getFields('loadings', 'cms_loading');
        $this->page->loading_titles = $this->model()->getTitles('loadings', 'cms_loading');
        $this->page->loading_data = $this->model()->getList('loadings', $this->model()->getFieldsNames('loadings', 'cms_loading'), $showCond);
        $this->page->delivery_fields = $this->model()->getFields('deliveries', 'cms_delivery');
        $this->page->delivery_titles = $this->model()->getTitles('deliveries', 'cms_delivery');
        $this->page->delivery_data = $this->model()->getList('deliveries', $this->model()->getFieldsNames('deliveries', 'cms_delivery'), $showCond);
        $this->page->after_show = $this->renderView('loading_delivery', '/../../site/views/cms');
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }

    public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('currency'), array('currency' => array('keyField' => 'id')), true);
        return parent::actionModify();
    }

    public function actionMulty_delete() {
        if(isset($_POST['multiple_items'])) {
            $multiple_items_id = $_POST['multiple_items'];
            $this->model()->Delete('transport_req', array('id' => array('IN', $multiple_items_id,'(?li)')));
            header('Location: '.zf::$root_url.'transport_req/list/');
        }
    }
}