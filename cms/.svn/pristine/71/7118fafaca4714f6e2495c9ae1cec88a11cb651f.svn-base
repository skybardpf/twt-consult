<?php
class Site_Content_Controller extends Site_Controller
{
	public function actionDefault($loadView = 1, $renderView = '', $title = '', $notFound = 0, $model = 'content')
    {
      /*
    	$menu = $this->page->menu;
      if (empty($menu) and !is_array($menu)) {
          $this->page->menu = $this->model('content')->getTree();
      }
      */
      
      // menu items

        $path = $this->app->request->parr ? $this->app->request->parr : array('/');
		$page_content = $this->model($model)->getContentByPath($path);
		if (!isset($page_content['content']) or count($page_content['content']) == 0 || $notFound) {
			return $this->actionNotFound($loadView);
		}
		$this->page->page_content = $page_content;
		$meta = $this->page->meta;
		if (empty($meta['title']) or $this->defaul_meta)       $meta['title']       = empty($page_content['meta_title'])       ? $page_content['title'] : $page_content['meta_title'];
		if (empty($meta['keywords']))    $meta['keywords']    = empty($page_content['meta_keywords'])    ? '' : $page_content['meta_keywords'];
		if (empty($meta['description'])) $meta['description'] = empty($page_content['meta_description']) ? '' : $page_content['meta_description'];

		$this->page->meta = $meta;

    	if (!empty($title)) {
			$this->page->title = $title;
    	} /*else {
			$this->page->title = $page_content['content']['title'];
    	}*/

		if ($renderView) {
			$pContent = $this->renderView($renderView);
		}

    	if ($loadView) {
    		$this->loadView(is_numeric($loadView) ? 'main' : $loadView,null);
		}

    	return $page_content;
    }

    public function actionZf_Resize_Images(){
        if ($this->app->mode != 'console') return true;
        if (empty($this->app->request->parr[1])) {
            echo <<<RESIZERHELP

===============================================================================
The right usage is Zf_Resize_Images/<model_name>/[table_name]
model_name defines which model will be run
table_name defines which table needs to be resized (if not set model will use
    all installeable (dont_install: 0) tables.
===============================================================================

RESIZERHELP;
            exit;
        }
        $this->model($this->app->request->parr[1], $this->app->request->parr[1])->zf_Resize_Images(empty($this->app->request->parr[2]) ? null : $this->app->request->parr[2]);
        exit;
    }
}
?>