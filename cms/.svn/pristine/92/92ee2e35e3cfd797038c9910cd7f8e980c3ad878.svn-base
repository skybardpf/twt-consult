<?php
class ContentController extends CMS_Controller
{
    protected $tree = 1;
    
    public function run()
    {
        $this->actionTree();
        $this->page->panel = $this->page->content;
        $this->posCond = array('pid' => $this->app->request->pid ? $this->app->request->pid : 1);
        parent::run();
    }
	
    public function actionDefault()
    {
        return $this->actionList();
    }
    
    public function actionChange($tableName = null, $modelNameOrModel = null)
    {
        misc::empty_dir('.zf_cache/content/');
        return parent::actionChange($tableName, $modelNameOrModel);
    }
    
	public function actionList($tableName = null, $modelNameorModel = null)
	{
		$pid = $this->app->request->pid ? $this->app->request->pid : 1;
		$this->app->request->pid = $pid;
        $this->listCond = array('where'=> array('pid' => $pid));
        $this->use_folder = 'content';
        return parent::actionList();
	}
    
    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model('content')->initValues(array('pid'));
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }
    
	public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model('content')->initValues(array('pid'), $this->app->request->id);
        if (isset($this->model()->conf['tables']['content']['fields']['roles']['virtual'])) {
        	$this->model('content')->initValues(array('roles'));
        }
   		if (isset($this->model()->conf['tables']['content']['fields']['categories']['virtual'])) {
        	$this->model('content')->initValues(array('categories'));
        }
        zf::addJS('content', '/public/cms/js/content.js');
        if (file_exists('public/site/js/external.js')) {
        	zf::addJS('content', '/public/site/js/external.js');
        }
        if ($this->app->request->id == 1) {
			$this->fields     = $this->model('content')->getFields('content', 'modify_main');
			$this->page->main = 1;
        }
        if ($this->app->request->pid) {
        	$this->page->parents = $this->model('content')->getParents(null, $this->app->request->pid);
        }
        else {
        	$this->page->parents = $this->model('content')->getParents($this->app->request->id);
        }
        if ($_POST and isset($_POST['pid'])) {
            $this->app->request->pid = $_POST['pid'];
        }
        misc::empty_dir('.zf_cache/content/');
        return parent::actionModify();
    }
    
    public function actionAdd($tableName = null, $modelNameorModel = null, $addData = array())
    {
    	if (file_exists('public/site/js/external.js')) {
        	zf::addJS('content', '/public/site/js/external.js');
        }
    	
        $this->model('content')->initValues(array('pid' => $this->app->request->pid));
    	if (isset($this->model()->conf['tables']['content']['fields']['roles']['virtual'])) {
        	$this->model('content')->initValues(array('roles'));
        }
    	if (isset($this->model()->conf['tables']['content']['fields']['categories']['virtual'])) {
        	$this->model('content')->initValues(array('categories'));
        }
        $this->page->parents = $this->model('content')->getParents(null, $this->app->request->pid);
        if ($_POST) {
            $this->app->request->pid = $_POST['pid'];
        }
        misc::empty_dir('.zf_cache/content/');
        return parent::actionAdd();
    }
    
	public function actionDelete($tableName = null, $modelNameorModel = null)
    {
		misc::empty_dir('.zf_cache/content/');
    	return parent::actionDelete();
    }
    
    public function setTitle($action = null)
    {
        $bc   = array();
        $tree = array();
        $this->model('content')->spreadTree($this->tree, $tree);
        
        $id = $this->app->request->id ? $this->app->request->id : $this->app->request->pid;
        while ($id) {
        	if (!empty($tree[$id])) {
	            $bc[] = array(
	                'title' => $tree[$id]['title'],
	                'link'  => "content/list/pid/{$tree[$id]['id']}",
	            );
	            $id = $tree[$id]['pid'];
        	} else {
        		$id = false;
        	}
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
    
    public function actionTree() 
    {
        $this->page->vTree     = $this->tree = $this->model('content')->getTree(0, 0, 0, true);
        $this->page->treeLevel = 0;
    	zf::addJS('jquery','/public/zf/js/jquery.js');
    	zf::addJS('ui.core','/public/zf/js/jquery/ui.core.js');
    	zf::addJS('jquery.cookie','/public/zf/js/jquery/jquery.cookie.js');
    	zf::addJS('jquery.simple.tree','/public/cms/js/jquery.simple.tree.js');
    	zf::addJS('tree_view','/public/cms/js/tree_view.js');
    	zf::addCSS('simpletree', '/public/cms/css/simpletree.css');
    	
    	$this->page->content = $this->renderView('tree', 'content');
    }
    
}
?>
