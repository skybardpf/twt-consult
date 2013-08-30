<?php
class ImagesController extends CMS_Controller
{
	public $model = '';
	public function __construct($ctrlName, $app)
	{
		parent::__construct($ctrlName, $app);
		$this->model = $this->app->request->model;
	}
    
    public function actionDefault()
    {
        return $this->actionList();
    }
    
    public function actionChange($tableName = null, $modelNameOrModel = null)
    {
        if (!$tableName) $tableName = $this->ctrlName;
        if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;

        $model   = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
        $field   = $this->app->request->field;
        $currVal = misc::get($model->Get($this->app->request->id, $tableName, array($field)), $field);
        $values  = misc::get(misc::get($model->getFields($tableName, array($field)), $field), 'values');
        
        unset($values[$currVal]);
        $newVal  = key($values);
        $model->Save($tableName, array($field => $newVal), $this->app->request->id);
        
        header(
            'Location: '.
            zf::$root_url.$this->ctrlName.
            '/'.
            (($this->app->request->ret_action) ? $this->app->request->ret_action : '').
            (($this->app->request->pid) ? "/pid/{$this->app->request->pid}/" : '').
            (($this->app->request->model) ? "model/{$this->app->request->model}/" : '')
        ).'/';
        exit;
    }
    
    public function actionList() 
    {
	    $this->check_init_values();
    	$this->page->top_content = "<a href=\"". zf::$root_url. "projects/modify/id/{$this->app->request->pid}/\">"
                                 . "вернуться к редактированию проекта</a>";
    	$this->posCond  = array('pid' => $this->app->request->pid, 'model' => $this->app->request->model);
    	$this->listCond = array('where' => $this->posCond);
    	$this->app->request->link = "model/{$this->app->request->model}/pid/{$this->app->request->pid}";
    	$ret = parent::actionList();
        return $ret;
    }
    
	public function actionModify()
    {
	    $this->check_init_values();
        $this->app->request->link = "model/{$this->app->request->model}/pid/{$this->app->request->pid}";
    	return parent::actionModify(null, null, array('model' => $this->app->request->model, 'pid' => $this->app->request->pid));
    }
    
 	public function actionAdd()
    {
	    $this->check_init_values();
    	$this->app->request->link = "model/{$this->app->request->model}/pid/{$this->app->request->pid}";
    	return parent::actionAdd(null, null, array('model' => $this->app->request->model, 'pid' => $this->app->request->pid));
    }
    
	public function actionDelete()
    {
		$this->app->request->link = "model/{$this->app->request->model}/pid/{$this->app->request->pid}";
        return parent::actionDelete();
    }
    
	public function actionDelete_image()
    {
    	$this->app->request->link = "model/{$this->app->request->model}/pid/{$this->app->request->pid}";
    	return parent::actionDelete_file();
    }

	public function actionShow($tableName = null, $model = null, $addData = array())
	{
		$this->check_init_values();
		return parent::actionShow($tableName, $model, $addData);
	}

	protected function check_init_values() {
		if (!empty($this->conf['init_values']) && !empty($this->conf['init_values'][$this->action])) {
			$misc = !empty($this->conf['init_values'][$this->action]['misc']) ? !empty($this->conf['init_values'][$this->action]['misc']) : array();
			$this->model()->initValues($this->conf['init_values'][$this->action]['fields'], $misc);
		}
	}
}
?>