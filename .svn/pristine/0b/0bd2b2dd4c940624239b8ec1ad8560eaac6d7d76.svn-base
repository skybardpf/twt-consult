<?php
class NewsController extends Site_Controller
{
    public function actionDefault()
    {
        $meta_t = $this->model('meta_tags')->GetByCond('meta_tags', array(), array('where' => array('url' => $this->app->request->uri, 'isActive' => 'yes')));
        if(!$meta_t) {
            $meta_tags['title'] = 'Новости';
            $meta_tags['keywords'] = 'Новости';
            $meta_tags['description'] = 'Новости';
            $this->page->meta = $meta_tags;
        }
		/***************** Блок Новости *********************/
        $npp = (isset($this->page->settings['news_cnt']) && !empty($this->page->settings['news_cnt'])) ? $this->page->settings['news_cnt'] : 10;
        $total = 0;
        $page_number = 1;

        if (!empty($_GET['page'])) {
            $page_number = $_GET['page'];
            $from = $npp * ($page_number - 1);
        }
        $from = $npp*($page_number - 1);

        $base_url1 = '?page=';
        //$this->page->base_url = '?'.(!empty($base_url) ? implode('&', $base_url) : '').(!empty($_GET['page']) ? '&page='.$page_number : '');

        $this->page->news = $this->model('news')->getPageJoined(
            'news',
            $this->model('news')->getFieldsNames('news', 'site_news'), $total, $from, $npp,
            array(
                'where' => array('active' => 'yes'),
                'order' => array('id' => "DESC")
            )
        );

        $this->page->bread_crumbs = array(
            '/' => 'Главная',
            '' => 'Новости'
        );

        $paging = array(
            'npp' => $npp, 'total' => $total, 'from' => $from,
            'url_append' => '',
            'base_url' => $base_url1
        );
        $paging['from'] = $from;
        $paging['curr_page']  = $page_number;
        $paging['pages']      = ceil($paging['total']/$paging['npp']);

        $this->page->paging = $paging;

        $this->page->content = $this->renderView('news', 'news'); //имя файла, имя папки
        $this->loadView('main', null);
        /***************** END *********************/
    }

    public function actionNew()
    {
        $new_id = $this->app->request->id;
        if($new_id) {
            $this->page->new = $new = $this->model('news')->GetByCond(
                'news',
                $this->model('news')->getFieldsNames('news', 'site_new'),
                array(
                    'where' => array('id' => $new_id, 'active' => 'yes')
                )
            );
            $meta_t = $this->model('meta_tags')->GetByCond('meta_tags', array(), array('where' => array('url' => $this->app->request->uri, 'isActive' => 'yes')));
            if(!$meta_t) {
                $meta_tags['title'] = $new['title'];
                $meta_tags['keywords'] = $new['title'];
                $meta_tags['description'] = $new['title'];
                $this->page->meta = $meta_tags;
            }
            $this->page->bread_crumbs = array(
                '/news' => 'Новости',
                '' => $new['title']
            );
        } else {
            return $this->actionNotFound('main');
        }
        $this->page->content = $this->renderView('new', 'news'); //имя файла, имя папки
        $this->loadView('main', null);
        /***************** END *********************/
    }
}
?>
