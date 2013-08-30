<?php
class Kind_activitiesController extends CMS_Controller {
    public function actionList() {
        $this->page->sLink = '/admin/kind_activities/';
        parent::actionList();
    }
}