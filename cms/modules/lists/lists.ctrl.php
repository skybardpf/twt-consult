<?php
class ListsController extends CMS_Controller
{
    public function actionDefault()
    {
        header('Location: '.zf::$root_url.'lists/list_'.($this->app->request->pid ? 'records' : 'lists').'/');
        exit;
    }
    
    public function run()
    {
        $this->setPanel();
        return parent::run();
    }
    
    public function actionList_lists()
    {
        return parent::actionList();
    }
    
    public function actionList_records()
    {
        $this->listCond = array('where' => array('pid' => $this->app->request->pid));
    	return parent::actionList('lists_records');
    }
    
    public function actionAdd_list()
    {
        parent::actionModify();
    }
    
    public function actionAdd_record()
    {
        parent::actionModify('lists_records', null, array('pid' => $this->app->request->pid));
    }
    
    public function actionModify_list()
    {
        parent::actionModify();
    }
    
    public function actionModify_record()
    {
        parent::actionModify('lists_records');
    }
    
    public function actionSmodify_record()
    {
        $this->currAction = 'smodify';
        parent::actionModify('lists_records');
    }
    
    public function actionDelete_list()
    {
        parent::actionDelete();
    }
    
    public function actionDelete_record()
    {
        parent::actionDelete('lists_records');
    }
    
    protected function setPanel()
    {
        $lists = $this->model('lists')->getList('lists', array('id', 'title'), array('order' => array('pos' => 'asc')));
        $items = array();
        if (!$this->app->request->pid && $lists) $this->app->request->pid = $lists[0]['id'];
        foreach ($lists as $item) {
            $items[] = array(
                'id'    => $item['id'],
                'title' => $item['title'],
            );
        }
        $this->page->panelItems  = $items;
        $this->page->panelAction = 'list_records';
        $this->page->panel       = $this->renderView('panel', 'page');
    }
}
?>
