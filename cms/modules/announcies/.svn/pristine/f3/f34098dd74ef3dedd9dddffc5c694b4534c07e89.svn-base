<?php
class AnnounciesController extends CMS_Controller {

    public function actionAdd()
    {
        parent::actionAdd(null, null, array('created' => date('Y-m-d')));
    }

    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('announcies', array('id' => $this->app->request->id), $this->app->request->field);
        header("Location: /admin/announcies/modify/id/".$this->app->request->id);
    }
    public function actionList() {
        $this->page->sLink = '/admin/announcies/';
        parent::actionList();
    }
}