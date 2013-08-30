<?php
class SiteusersController extends CMS_Controller
{
    public function actionList_companies(){
        if (!$this->app->request->pid) {
            header('Location: /admin/siteusers/');
            exit;
        }
        $this->model()->initValues(array('user_id'));
        $this->listCond = array('where' => array('user_id' => $this->app->request->pid));
        parent::actionList('companies');
    }
    
    public function actionAdd_companies(){
        if (!$this->app->request->pid) {
            header('Location: /admin/siteusers/');
            exit;
        }
        $this->model()->initValues(array('user_id'));
        parent::actionAdd('companies', null, array('user_id' => $this->app->request->pid, 'created' => date('Y-m-d H:i:s')));
    }
    
    public function actionModify_companies(){
        if (!$this->app->request->pid) {
            header('Location: /admin/siteusers/');
            exit;
        }
        $this->model()->initValues(array('user_id'));
        parent::actionModify('companies', null, array('user_id' => $this->app->request->pid));
    }
    
    public function actionShow_companies(){
        if (!$this->app->request->pid) {
            header('Location: /admin/siteusers/');
            exit;
        }
        $this->model()->initValues(array('user_id'));
        parent::actionShow('companies', null, array('user_id' => $this->app->request->pid));
    }
    
    public function actionDelete_companies(){
        if (!$this->app->request->pid) {
            header('Location: /admin/siteusers/');
            exit;
        }
        parent::actionDelete('companies');
    }
}
?>