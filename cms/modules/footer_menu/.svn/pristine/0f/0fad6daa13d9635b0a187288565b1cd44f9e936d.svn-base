<?php
class Footer_menuController extends CMS_Controller {
    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('pid'));
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }

    public function actionList()
    {
        $this->page->sLink = '/admin/footer_menu/';
        if ($this->app->request->pos) {
            $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
            $cacher->put('footer_menu', cacher::EXPIRED);
        }
        parent::actionList();
    }

    public function actionModify()
    {
        $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
        $cacher->put('footer_menu', cacher::EXPIRED);
        $this->model()->initValues(array('pid'), $this->app->request->id);
        return parent::actionModify();
    }

    public function actionAdd()
    {
        $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
        $cacher->put('footer_menu', cacher::EXPIRED);
        $this->model()->initValues(array('pid'), $this->app->request->id);
        return parent::actionAdd();
    }

    public function actionDelete()
    {
        $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
        $cacher->put('footer_menu', cacher::EXPIRED);
        return parent::actionDelete();
    }

    public function actionChange()
    {
        $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
        $cacher->put('footer_menu', cacher::EXPIRED);
        return parent::actionChange();
    }
    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('footer_menu', array('id' => $this->app->request->id), $this->app->request->field);
        header('Location: '.zf::$root_url.'/footer_menu/modify/id/'.$this->app->request->id);
    }
}