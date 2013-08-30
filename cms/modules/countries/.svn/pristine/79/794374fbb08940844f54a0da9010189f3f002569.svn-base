<?php
class CountriesController extends CMS_Controller {
    public function actionDelete_image() {
        $this->model()->deleteFileFromElement('countries', array('id' => $this->app->request->id), $this->app->request->field);
        header('Location: '.zf::$root_url.'countries/modify/id/'.$this->app->request->id);
    }
    public function actionList() {
        $this->page->sLink = '/admin/countries/';
        parent::actionList();
    }
    /*public function actionList() {
        // Test CVS
        if (file_exists(ROOT_PATH . '/Excel/reader.php')){
            require_once ROOT_PATH . 'Excel/reader.php';
        }


        $data = new Spreadsheet_Excel_Reader();


        // Set output Encoding.
        $data->setOutputEncoding('UTF-8');

        $data->read('countries.xls');
        $datas = $data->sheets[0]['cells'];
        debug::dump($datas);
        $regions = array();
        $sum = 0;
        for($i=2; $i<=count($datas); $i++){
            $row = $datas[$i];
            $text = trim($row[2]);
            $code = $row[1];
            $str = mb_strtolower($text);
            $str = mb_strtoupper(mb_substr($str, 0, 1)).mb_substr($str, 1, mb_strlen($str));
            if(!$res = $this->model()->GetByCond('countries', array('id'), array("where" => array('title' => $str)), 1)) {
                $this->model()->Save('countries', array('title' => $str, 'code' => $code));
                //debug::dump($str);
            }
        }
        error_reporting(E_ALL ^ E_NOTICE);

        parent::actionList();
    }*/
}