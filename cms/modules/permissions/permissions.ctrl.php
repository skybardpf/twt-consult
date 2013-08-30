<?php
class PermissionsController extends CMS_Controller
{
//    protected $viewsDir = '';
    protected $ctrls    = array();
    
    public function actionManage()
    {
        zf::addJS('permissions', '/public/cms/js/permissions.js');
        $fields = $this->model()->getFields($this->ctrls[$this->app->request->ctrl]);
        $this->loadForm(
            'modify',
            array_merge($fields, array('post' => array('htmltype' => 'hidden'))),
            $this->model()->getCurrentPermissions($this->app->request->ctrl, $this->app->request->pid)
        );
        if ($_POST) {
            $this->model()->Save($_POST, $this->app->request->ctrl, $this->app->request->pid);
            header('Location: '.
                zf::$root_url."{$this->ctrlName}/manage/ctrl/{$this->app->request->ctrl}/pid/{$this->app->request->pid}/"
            );
            exit;
        }
        $this->page->content = $this->renderView('modify', 'actions');
    }
    
    public function run()
    {
        $this->ctrls = CMS_Controller::getAvailableCtrls();
        if (!$this->app->request->ctrl) $this->app->request->ctrl = key($this->ctrls);
        $items = array();
        $this->page->panelCheck = $this->app->request->ctrl;
        foreach ($this->ctrls as $ctrlName => $ctrl) {
            if (!isset($ctrl['title']) || empty($ctrl['title'])) continue;
            $items[] = array(
                'id'    => $ctrlName,
                'title' => $ctrl['title'],
                'link'  => "manage/pid/{$this->app->request->pid}/ctrl/$ctrlName",
                'check' => $ctrlName
            );
        }
        $this->page->panelItems  = $items;
        $this->page->panel       = $this->renderView('panel', 'page');
        reset($this->ctrls);
        $this->setTitle();
        return AdvancedController::run();
    }
    
    public function setTitle($action = null)
    {
        $this->page->pageTitle = array(
            $this->conf['title'],
            'Роль "'.misc::get(
                $this->model('users', 'users')->Get($this->app->request->pid, 'user_roles', array('title')),
                'title'
            ).'"'
        );
       $this->page->actionTitle = 'Модуль "'.$this->ctrls[$this->app->request->ctrl]['title'].'"';
        //parent::setTitle($action);
        return;
        $bc   = array();
        $tree = array();
        $this->model('content')->spreadTree($this->tree, $tree);
        
        $id = $this->app->request->id ? $this->app->request->id : $this->app->request->pid;
        while ($id) {
            $bc[] = array(
                'title' => $tree[$id]['title'],
                'link'  => "content/list/pid/{$tree[$id]['id']}",
            );
            $id = $tree[$id]['pid'];
        }
        $bc = array_reverse($bc);
        if ($action == 'list') {
            $this->page->pageTitleLast = misc::get(array_pop($bc), 'title');
        } else {
            array_pop($bc);
        }        
        $this->page->pageTitle = $bc;
        parent::setTitle($action);
    }
    
    public function OnBeforeCompile(&$conf, &$errors)
    {
        return;
    }
}
?>
