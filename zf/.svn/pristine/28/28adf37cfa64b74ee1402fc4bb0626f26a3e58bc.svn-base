<?php
class ContentController extends Controller
{
	public function actionDefault()
	{
		$this->loadForm('form', array(
			array('name' => 'int12', 'htmltype' => 'text', 'title' => 'Name 4545454 5', 'value' => 45 )    
		));
		
		$this->page->set('elements', $this->form('form')->getElNames());
		
		
		if ($this->app->request->post) {
			//$this->model('content')->Update($this->app->zf->id, $this->app->request->post);
		}
		$this->loadView('main');
		
		
/*        $fields = array();
		foreach ($fromSQL as $row) {
			if ($row[])
		}*/
	}
}


class SomeType
{
	public function toForm()
	{
		return 10;
	}
	
	static function gi()
	{
		return new self();
	}
}
?>