<?php
class MenuController extends CMS_Controller {
    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('menu', array('id' => $this->app->request->id), $this->app->request->field);
        header('Location: '.zf::$root_url.'/menu/modify/id/'.$this->app->request->id);
    }
    public function actionList() {
        $this->page->sLink = '/admin/menu/';
        parent::actionList();
    }
}