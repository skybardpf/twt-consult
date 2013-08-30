<?php
class Frames_25Controller extends CMS_Controller {
    public function actionAdd()
    {
        parent::actionAdd(null, null, array('created' => date('Y-m-d')));
    }

    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('frames_25', array('id' => $this->app->request->id), $this->app->request->field);
        header('Location: '.zf::$root_url.'/frames_25/modify/id/'.$this->app->request->id);
    }
    public function actionList() {
        $this->page->sLink = '/admin/frames_25/';
        parent::actionList();
    }
}