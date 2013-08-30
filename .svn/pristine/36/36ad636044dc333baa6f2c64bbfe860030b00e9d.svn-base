<?php
class CountriesController extends Site_Controller
{
    public function actionDefault()
    {
        $country_id = $type = null;
        if ($this->app->request->url) {
            $country_id = $this->app->request->url;
            $type = 'url';
        } elseif ($this->app->request->id) {
            $country_id = $this->app->request->id;
            $type = 'id';
        }

        if (!$type) {
            return $this->CountryList();
        }

        if($country_id) {
            $this->page->one_country = $country = $this->model('countries')->GetByCond(
                'countries',
                $this->model('countries')->getFieldsNames('countries', 'site_new'),
                array(
                    'where' => array($type => $country_id, 'in_list' => 'yes', 'active' => 'yes')
                )
            );
            $this->page->bread_crumbs = array(
                '/' => 'Главная',
                '/countries' => 'Страны',
                '' => $country['title']
            );
            $meta = $this->page->meta;
            if (count($meta) < 2) {
                $meta['title'] = $country['title'];
                $meta['keywords'] = $country['title'];
                $meta['description'] = $country['title'];
                $this->page->meta = $meta;
            }
        } else {
            return $this->actionNotFound('main');
        }
        $this->page->content = $this->renderView('country', 'countries'); //имя файла, имя папки
        $this->loadView('main', null);
    }

    public function CountryList()
    {
        $this->page->bread_crumbs = array(
            '/' => 'Главная',
            '' => 'Страны'
        );
        $this->page->countries = $this->model()->getList(
            'countries',
            'site_list',
            array(
                'where' => array(
                    '!raw' => 'text IS NOT NULL AND active = \'yes\' AND  in_list = \'yes\''
                ),
                'order' => array(
                    'title' => 'ASC'
                )
            )
        );
        $meta = $this->page->meta;
        if (count($meta) < 2) {
            $meta['title'] = 'Страны';
            $meta['keywords'] = 'Страны';
            $meta['description'] = 'Страны';
            $this->page->meta = $meta;
        }
        $this->page->content = $this->renderView('countries'); //имя файла, имя папки
        $this->loadView('main', null);
    }

    public function actionGetprice(){
        $price = $this->model()->GetByCond('countries',array('price_final'), array('where'=>array('code'=>$_GET['id'],'in_list'=>'yes')));
        if($price){
            echo $price['price_final'];
        }
        exit();
    }
}
?>
