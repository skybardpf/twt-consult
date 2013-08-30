<?php
class ServicesController extends CMS_Controller {

    public function actionShow($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $this->model()->initValues(array('pid'));
        parent::actionShow($tableName, $modelNameorModel, $addData);
    }

    public function actionList()
    {
        $this->page->sLink = '/admin/services/';
        if ($this->app->request->pos) {
            $cacher = $this->app->getCacher('.zf_cache/services', 600);
            $cacher->put('services', cacher::EXPIRED);
        }
        parent::actionList();
    }

    public function actionModify($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $cacher = $this->app->getCacher('.zf_cache/services', 600);
        $cacher->put('services', cacher::EXPIRED);
        $this->model()->initValues(array('pid'), $this->app->request->id);
        return parent::actionModify();
    }

    public function actionAdd($tableName = null, $modelNameorModel = null, $addData = array())
    {
        $cacher = $this->app->getCacher('.zf_cache/services', 600);
        $cacher->put('services', cacher::EXPIRED);
        $this->model()->initValues(array('pid'), $this->app->request->id);
        return parent::actionAdd();
    }

    public function actionDelete_image()
    {
        $this->model()->deleteFileFromElement('services', array('id' => $this->app->request->id), $this->app->request->field);
        header('Location: '.zf::$root_url.'/services/modify/id/'.$this->app->request->id);
    }

    public function actionDelete()
    {
        $cacher = $this->app->getCacher('.zf_cache/services', 600);
        $cacher->put('services', cacher::EXPIRED);
        return parent::actionDelete();
    }

    public function actionChange()
    {
        $cacher = $this->app->getCacher('.zf_cache/services', 600);
        $cacher->put('services', cacher::EXPIRED);
        return parent::actionChange();
    }
    
    public function actionList_additional() { 
        $this->page->sLink = '/admin/services/list_additional/';
        return parent::actionList('additional'); 
    }
    
    public function actionShow_additional() { return parent::actionShow('additional'); }
    public function actionAdd_additional() { return $this->actionModify_additional(); }
    public function actionModify_additional() { return parent::actionModify('additional'); }
    public function actionDelete_additional() { return parent::actionDelete('additional'); }
    public function actionChange_additional() { return parent::actionChange('additional'); }
    
    public function actionGetSitemap() { 
        //адрес вашего сайта
        $ServerUrl = 'http://'.$_SERVER['HTTP_HOST'];
        // создаем новый xml документ
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        // массив страницы для sitemap
        $pages = array(
            array(
                'url' => '/',
                'changefreq' => 'daily',
                'priority' => '1.00',
            ),
            array(
                'url' => '/sitemap',
                'changefreq' => 'daily',
                'priority' => '0.90',
            ),
        );

        //Получаем все статьи из БД
        // и добавляем их в массив
        $arts = $this->model('content', 'content')->getList('content', array('id', 'path'), array('hidden' => 'no'));

        if (!empty($arts)) {
            foreach($arts as $art) {
                $pages[] = array(
                    'url' => $art['path'] == '/' ? $art['path'] : '/'.$art['path'],
                    'changefreq' => 'daily',
                    'priority' => '0.80',
                );
            }
        }
        
        $arts = $this->model()->getList('services', array('id', 'url'), array('active' => 'yes'));
        if (!empty($arts)) {
            foreach($arts as $art) {
                $pages[] = array(
                    'url' => '/servises/'.$art['url'],
                    'changefreq' => 'daily',
                    'priority' => '0.80',
                );
            }
        }
        
        //вывод на экран количества страниц в sitemap
        //var_dump(sizeof($pages));

        $SITEMAP_NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        $SITEMAP_NS_XSD = 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd';

        // ...and urlset (root) element
        $urlSet = $dom->createElementNS($SITEMAP_NS, 'urlset');
        $dom->appendChild($urlSet);
        $urlSet->setAttributeNS('http://www.w3.org/2000/xmlns/' ,
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance');
        $urlSet->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance',
            'schemaLocation',
            $SITEMAP_NS . ' ' . $SITEMAP_NS_XSD);

        foreach($pages as $page) {

            $url = $ServerUrl . $page['url'];
            // create url node for this page
            $urlNode = $dom->createElementNS($SITEMAP_NS, 'url');
            $urlSet->appendChild($urlNode);

            // put url in 'loc' element
            $urlNode->appendChild($dom->createElementNS(
                $SITEMAP_NS,
                'loc', $url));
            $urlNode->appendChild(
                $dom->createElementNS(
                    $SITEMAP_NS,
                    'changefreq',
                    $page['changefreq'])
            );

            $urlNode->appendChild(
                $dom->createElementNS(
                    $SITEMAP_NS,
                    'priority',
                    $page['priority'])
            );
        }

        $xml = $dom->saveXML();
        //debug::dump($xml);
        //сохраняем файл sitemap.xml на диск
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml' , $xml);
        header('Location: /admin/settings');
        exit;
    }
}