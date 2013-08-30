<?php
class NewsController extends CMS_Controller
{
    public function actionAdd()
    {
        parent::actionAdd(null, null, array('created' => date('Y-m-d')));
    }
    
    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('news', array('id' => $this->app->request->id), $this->app->request->field); 
        header('Location: '.zf::$root_url.'/news/modify/id/'.$this->app->request->id);
    }

    public function actionList() {
        $this->listCond = array('order' => array('id' => 'DESC'));
        parent::actionList();
    }
}