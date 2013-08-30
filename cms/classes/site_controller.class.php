<?php
class Site_Controller extends Controller
{
	/**
	* Stores zfApp object
	* 
	* @var Site
	*/
	public $app;

    /**
     * значение поля priceGroup, по которому определяются распродаваемые товары
     */
    const PRICEGROUP_WELLSELL = 'Распродажа';
	
	/**
	 * @return CMS_Model
	 */
	public function model($modName = null, $ctrlName = '')
	{
		return parent::model($modName, $ctrlName);
	}
	
    public function actionDefault()
    {
        $this->actionNotFound();
    }
  
	protected $defaul_meta = false;
	public function run()
	{
		$meta = $this->page->meta;
		if (empty($meta['title'])) {
			$this->defaul_meta = true;
			$tmp = $this->page->meta;
			$tmp['title'] = $this->app->conf['title'];
			$this->page->meta = $tmp;
		}
		parent::run();
/*		
		debug::add($this->page->selected_menu);
		if($this->page->selected_menu === null) {
			$this->page->selected_menu = "nothing";
		}
		$this->page->topmenu = $this->getTopMenu();
*/		
	}

/*		
	protected function getTopMenu(){
		$categories = $this->model('menu', 'menu');
		$this->page->menu_items = $categories->getList('menu',
				$categories->getFieldsNames('menu','site_list'),
				array('where'=>array('display'=>'yes'), 'order'=>array('pos'=>'asc'))
		);
	
		return $this->renderView('topmenu', null);
	}
*/
	
    /**
     * @param int $loadView
     * @return void
     */
	public function actionNotFound($loadView = 1)
    {
    	header('HTTP/1.0 404 Not Found');
    	$this->page->meta = array(
    			'title' => 'Ошибка 404. Документ не найден.',
    			'description' => 'Данная страница не найдена на сервере.',
    			'keywords' => '404, страница, не найдена, not found',
		);
		$this->page->this_is_404_not_found = true;
        $this->page->content = $this->renderView('404',null);
    	if ($loadView) {
    		$this->loadView(is_numeric($loadView) ? 'main' : $loadView, null);
		}
    }
}
?>
