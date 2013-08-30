<?php
class SearchController extends Site_Controller {
	public function actionDefault()
    {
	    if ($_GET['q'] !== '') {
	        $result = $this->model('search')->search($_GET['q'], '', (isset($_GET['p']) ? $_GET['p']-1 : 0)*20, 20);
		    $this->page->data = $result['data'];
		    $curr = $result['meta']['from']/ $result['meta']['npp'];
		    $this->page->paging = array(
	            'from'		 => $result['meta']['from'],
	            'url_append' => '',
	            'separator'  => ' ',
		        'base_url'   => '/search/page/?q='.$_GET['q'].'&p=',
	            'curr_page'  => $curr ? $curr+1 : 1,
	            'pages'      => ceil($result['meta']['total'] / $result['meta']['npp']),
	            'first'      => '|<',
		        'prev'       => '<',
	            'next'       => '>',
	            'last'       => '>|',
		        'skip'       => ' ... ',
	            'linkcount'  => '10'
	        );
	    }
        $meta = $this->page->meta;
        if (count($meta) < 2) {
            $meta['title'] = 'Поиск';
            $meta['keywords'] = 'Поиск';
            $meta['description'] = 'Поиск';
            $this->page->meta = $meta;
        }
	    $this->page->content = $this->renderView('search', null);
    	$this->loadView('main', null);
    }
}