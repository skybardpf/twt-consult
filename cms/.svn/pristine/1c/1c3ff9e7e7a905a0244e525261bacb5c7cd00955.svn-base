<?php
class Site_Common_Controller extends Site_Controller
{
    /**
     * if returns true other controllers won`t run
     *
     * @param string $contentModelName
     * @return bool
     */
	public function run($contentModelName = 'content')
	{
        $mContent = $this->model($contentModelName);
		
		//хлебная крошка
		$path = $this->app->request->parr ? $this->app->request->parr : array('/');
		if ($this->app->ctrl->ctrlName != 'content') {
			$path = $this->app->request->parr;
			array_unshift($path, $this->app->ctrl->ctrlName);
		} else {
			$path = $this->app->request->parr ? $this->app->request->parr : array('/');
		}
		$uri = preg_replace('|/id/.+|','/', $this->app->request->uri);
		$bc = $mContent->getBreadCrumbs($path, $uri);
		$this->page->bread_crumbs = $bc;
		
		//меню
		$menu = $this->page->menu;
		if (empty($menu) and !is_array($menu)) {
			$temp = $this->app->request->parr
	        	? $this->app->request->parr
	        	: ( trim($this->app->request->uri, '/')
	        		? explode('/', trim($this->app->request->uri, '/'))
	        		: array('/')
	        );
	        $result = $mContent->getContentByPath($temp);
			$id  = isset($result['id']) ? $result['id'] : 0;
			$this->page->menu = $mContent->getTree();
			$menu = $this->page->menu;

			isset($result['id']) ? $this->page->submenu = $mContent->getTree($result['id'], 0, 0, false, trim($this->app->request->uri, '/')) : 1;
		}

		//настройки сайта
		$mContent = $this->model('settings');
		$this->page->settings = $mContent->getDataToForm();
		
		//мета-тэги для сайта
		$meta = $this->model('meta_tags', 'meta_tags')->getMeta(misc::get($_SERVER, 'REQUEST_ORIGINAL_URI', $this->app->request->uri));
		if (!empty($meta)) {
			$tmp_meta = array(
				'title' => $meta['meta_title'],
				'keywords' => $meta['meta_keywords'],
				'description' => $meta['meta_description']
			);
			$meta_add_fields = $this->model('meta_tags')->getFieldsNames('meta_tags', 'additional_fields');
			if (!empty($meta_add_fields)) {
				foreach ($meta_add_fields as $f) {
					$tmp_meta[$f] = $meta[$f];
				}

			}
			$this->page->meta = $tmp_meta;
		}
	}
}
?>
