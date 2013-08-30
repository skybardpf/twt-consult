<?php
class SourcesController extends CMS_Controller {
    public function actionList() {
        $this->page->sLink = '/admin/sources/';
        parent::actionList();
    }
}