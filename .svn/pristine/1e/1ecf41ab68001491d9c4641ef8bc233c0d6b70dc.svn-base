<?php
class ServicesController extends Site_Controller
{
    public function actionDefault() {
        if (count($this->app->request->parr) == 1 || count($this->app->request->parr) == 2) {
            $url = $this->app->request->parr[0];
            $is_price = false;
            if(count($this->app->request->parr) == 2 && $this->app->request->parr[1] == 'price') {
                $is_price = true;
            }
            $model_service = $this->model('services', 'services');
            $service_id = $model_service->GetByCond('services', array('id'), array('where' => array('url' => $url)));
            if($service_id) {
                $this->page->one_service = $one_service = $model_service->GetByCond(
                    'services',
                    $model_service->getFieldsNames('services', 'site_service'),
                    array(
                        'where' => array('id' => $service_id['id'], 'active' => 'yes')
                    ),
                    1
                );
                $meta_t = $this->model('meta_tags')->GetByCond('meta_tags', array(), array('where' => array('url' => $this->app->request->uri, 'isActive' => 'yes')));
                if(!$meta_t) {
                    $meta_tags['title'] = $one_service['title'];
                    $meta_tags['keywords'] = $one_service['title'];
                    $meta_tags['description'] = $one_service['title'];
                    $this->page->meta = $meta_tags;
                }
                $services = array();
                if($is_price) {
                    $services[] = array('title' => $one_service['title'].' прайс-лист', 'url' => '', 'pid' => $one_service['pid']);
                    $pid = $one_service['pid'];
                    $ids = array();
                    $ids[] = $one_service['id'];
                    while($pid) {
                        // Для хлебных крошек
                        $services[] = $par_serv = $model_service->GetByCond('services', array('id', 'title', 'url', 'pid'), array('where' => array('id' => $pid)), 1);
                        $pid = isset($par_serv['pid']) ? $par_serv['pid'] : 0;
                        $ids[] = $par_serv['id'];
                    }
                    $services = array_reverse ($services, TRUE);
                    $ids = array_reverse ($ids);
                    $this->page->service_ids = $ids;
                    $bread_arr = array('/' => 'Главная',
                    '/services/price_list/' => 'Прайс-лист');
                    foreach($services as $val) {
                        $u = (isset($val['url']) && $val['url']) ? '/services/'.$val['url'].'/price' : '';
                        $bread_arr[$u] = $val['title'];
                    }
                } else {
                    $services[] = array('title' => $one_service['title'], 'url' => '', 'pid' => $one_service['pid']);
                    $pid = $one_service['pid'];
                    $ids = array();
                    $ids[] = $one_service['id'];
                    while($pid) {
                        // Для хлебных крошек
                        $services[] = $par_serv = $model_service->GetByCond('services', array('id', 'title', 'url', 'pid'), array('where' => array('id' => $pid)), 1);
                        $pid = isset($par_serv['pid']) ? $par_serv['pid'] : 0;
                        $ids[] = $par_serv['id'];
                    }
                    $services = array_reverse ($services, TRUE);
                    $ids = array_reverse ($ids);
                    $this->page->service_ids = $ids;
                    $bread_arr = array('/' => 'Главная');
                    foreach($services as $val) {
                        $bread_arr[$val['url']] = $val['title'];
                    }
                }
                $this->page->bread_crumbs = $bread_arr;
            } else {
                return $this->actionNotFound('main');
            }
            if($is_price) {
                $this->page->content = $this->renderView('price', 'services'); //имя файла, имя папки
            } else {
                $this->page->content = $this->renderView('service', 'services'); //имя файла, имя папки
            }
            $this->loadView('main', null);
        } else {
            return $this->actionNotFound('main');
        }
    }

    public function actionService()
    {
        $service_id = $this->app->request->id;
        if($service_id) {
            $model_service = $this->model('services', 'services');
            $this->page->one_service = $one_service = $model_service->GetByCond(
                'services',
                $model_service->getFieldsNames('services', 'site_service'),
                array(
                    'where' => array('id' => $service_id, 'active' => 'yes')
                )
            );
            $meta_t = $this->model('meta_tags')->GetByCond('meta_tags', array(), array('where' => array('url' => $this->app->request->uri, 'isActive' => 'yes')));
            if(!$meta_t) {
                $meta_tags['title'] = $one_service['title'];
                $meta_tags['keywords'] = $one_service['title'];
                $meta_tags['description'] = $one_service['title'];
                $this->page->meta = $meta_tags;
            }
            $services = array();
            $services[] = array('title' => $one_service['title'], 'url' => '', 'pid' => $one_service['pid']);
            $pid = $one_service['pid'];
            $ids = array();
            $ids[] = $one_service['id'];
            while($pid) {
                // Для хлебных крошек
                $services[] = $par_serv = $model_service->GetByCond('services', array('id', 'title', 'url', 'pid'), array('where' => array('id' => $pid)), 1);
                $pid = isset($par_serv['pid']) ? $par_serv['pid'] : 0;
                $ids[] = $par_serv['id'];
            }
            $services=array_reverse ($services, TRUE);
            $ids = array_reverse ($ids);
            $this->page->service_ids = $ids;
            $bread_arr = array('/' => 'Главная');
            foreach($services as $val) {
                $bread_arr[$val['url']] = $val['title'];
            }
            $this->page->bread_crumbs = $bread_arr;
        } else {
            return $this->actionNotFound('main');
        }
        $this->page->content = $this->renderView('service', 'services'); //имя файла, имя папки
        $this->loadView('main', null);
    }

    public function actionPrice_list()
    {
        zf::addJS('services', '/public/site/js/services.js');
        $meta_t = $this->model('meta_tags')->GetByCond('meta_tags', array(), array('where' => array('url' => $this->app->request->uri, 'isActive' => 'yes')));
        if(!$meta_t) {
            $meta_tags['title'] = 'Прайс-лист';
            $meta_tags['keywords'] = 'Прайс-лист';
            $meta_tags['description'] = 'Прайс-лист';
            $this->page->meta = $meta_tags;
        }
        $model_service = $this->model('services', 'services');
        $this->page->price_list = $this->page->services;
        $this->page->bread_crumbs = array(
            '/' => 'Главная',
            '' => 'Прайс-лист'
        );
            /*$model_service->getList(
            'services',
            $model_service->getFieldsNames('services', 'site_services'),
            array(
                'where' => array('!raw' => 'active = \'yes\' AND price IS NOT NULL AND price != \'\'')
            )
        );*/
        $this->page->content = $this->renderView('pricelist', 'services'); //имя файла, имя папки
        $this->loadView('main', null);
    }
}
?>
