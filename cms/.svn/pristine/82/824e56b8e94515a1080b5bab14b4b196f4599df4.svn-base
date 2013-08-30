<?php
class UsersController extends CMS_Controller
{
    public $has_roles;
    
    public function run()
    {
        $this->has_roles = $this->model('users')->hasField('users','roles');
        
        return parent::run();
    }
    
    public function actionList()
    {
        $this->page->sLink = '/admin/users/';
        if ($this->has_roles) $this->listCond['order'] = array('users.pos' => 'ASC');
        return parent::actionList();
    }
    
    public function actionList_roles()
    {
        return parent::actionList('user_roles');
    }
    
    public function actionAdd()
    {
        if ($this->has_roles) $this->model('users')->initValues(array('roles'));
        if ($this->model('users')->hasField('users', 'ad')) $this->model('users')->initValues(array('ad'));
		if ($this->model('users')->hasField('users', 'dealers')) $this->model('users')->initValues(array('dealers'));
    	return parent::actionAdd();
    }
    
    public function actionModify($add = 0)
    {
        if ($this->has_roles) $this->model('users')->initValues(array('roles'));
        if ($this->model('users')->hasField('users', 'ad')) $this->model('users')->initValues(array('ad'));
        if ($this->model('users')->hasField('users', 'dealers')) $this->model('users')->initValues(array('dealers'));
        return parent::actionModify();
    }
    
    public function actionAdd_role()
    {
        return $this->actionModify_role();
    }
    
    public function actionModify_role()
    {
        return parent::actionModify('user_roles');
    }
    
    public function actionDelete_role()
    {
        return parent::actionDelete('user_roles');
    }
    
    public function actionList_logs()
    {
		$this->listCond['order'] = array('eTime' => 'DESC');
		return parent::actionList('actions_log');
    }
    
    public function get_listing_value($item, $key, $content)
    {
		return $this->model()->humanazeOutput($item, $key, $content);
    }
}
?>