<?php
class CabinetController extends Site_Controller
{
    public $user = null;
    public $modelUser = null;

    public function run()
    {
        $this->user = $this->app->session->siteuser;
        if (empty($this->user)) {
            if(isset($_GET['key']) && isset($_GET['mail'])){
                $model_user = $this->model('siteusers', 'siteusers');
                $uniq_key = $_GET['key'];
                $mail = $_GET['mail'];
                $usr = $model_user->GetByCond('siteusers', array('id'), array('where'=>array('email'=>$mail, 'uniq_key'=>$uniq_key, 'key_date' => array('>', date('Y-m-d H:i:s', time() - 24*3600)))), 1);
                if($usr) {
                    $model_user = $this->model('siteusers', 'siteusers');
                    $site_user = $model_user->GetByCond(
                        'siteusers', array(),
                        array('where' => array('email' => $mail)),
                        1
                    );
                    $this->app->session->siteuser = $site_user;
                    header('Location: /cabinet/');
                }
                else{
                    header('Location: /');
                    exit;
                }
            }
            else{
                header('Location: /');
                exit;
            }
        }
        if (!empty($_GET['msg'])) {
            $this->page->msg = urldecode($_GET['msg']);
        }

        $this->modelUser = $this->model('siteusers', 'siteusers');
        if ($this->action && !method_exists($this, 'action'.ucfirst($this->action))) {
            header('Location: /cabinet');
            exit;
            //debug::dump(method_exists($this, $this->action));
        }
        parent::run();
    }

    /***************** Личные данные *********************/
    public function actionDefault()
    {
        $fields = $this->modelUser->getFields('siteusers', 'cabinet');
        $dataPost = array_merge($this->user, $_POST);

        $this->loadForm('cabinet', $fields, $dataPost, '', 'POST');
        if (!empty($_POST) && !empty($_POST['cabinet']) && $this->form('cabinet')->validate()) {
            $data = $this->form('cabinet')->getData();
            debug::add_log("<b>/*** Сохраняем данные пользователя ***/</b>");
            if ($id = $this->modelUser->Save('siteusers', $data, array('id' => $this->user['id']))) {
                $this->app->session->siteuser = array_merge(array('id' => $this->user['id']), $data);
                header("Location: /cabinet?msg=Данные успешно сохранены!");
                exit;
            } else {
                header("Location: /cabinet");
                exit;
            }
        } else {
            $this->page->error_cabinet = $this->form('cabinet')->getErrors();
        }
        $this->page->dataBlock = 'personal';

        if(count($this->page->meta) < 2) {
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = 'ЛК - Личные данные';
            $this->page->meta = $meta_tags;
        }

        $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
        $this->loadView('main', null);

    }


    /***************** Смена пароля *********************/
    public function actionChange_pass()
    {
        $fields = $this->modelUser->getFields('siteusers', 'change_pass');
        $dataPost = array_merge($this->user, $_POST);

        $this->loadForm('cabinet', $fields, $dataPost, '', 'POST');
        if (!empty($_POST) && !empty($_POST['cabinet']) && $this->form('cabinet')->validate()) {
            $data = $this->form('cabinet')->getData();
            if ($data['password'] == $data['password2']) {
                debug::add_log("<b>/*** Сохраняем данные пользователя ***/</b>");
                if ($id = $this->modelUser->Save('siteusers', $data, array('id' => $this->user['id']))) {
                    $this->modelUser->SendMail($this->user['email'], array('pass' => $_POST['password']), 'change_pass');
                }
                header("Location: /cabinet/change_pass?msg=Ваш пароль успешно изменен!");
                exit;
            } else {
                $this->page->error_cabinet = array('Пароли не совпадают');
            }

        } else {
            $this->page->error_cabinet = $this->form('cabinet')->getErrors();
        }
        $this->page->dataBlock = 'change';

        if(count($this->page->meta) < 2) {
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = 'ЛК - Смена пароля';
            $this->page->meta = $meta_tags;
        }

        $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
        $this->loadView('main', null);

    }


    /***************** Компании *********************/
    public function actionCompanies()
    {
        debug::add_log("<b>/*** Достаём компании ***/</b>");
        $this->page->rows = $this->modelUser->getList(
            'companies',
            'cabinet',
            array(
                'where' => array(
                    'user_id' => $this->user['id']
                ),
                'order' => array(
                    'name' => 'ASC'
                )
            )
        );
        if(count($this->page->meta) < 2) {
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = 'ЛК - Компании';
            $this->page->meta = $meta_tags;
        }
        $this->page->dataBlock = 'companies';
        $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
        $this->loadView('main', null);

    }
    public function actionAddCompany()
    {
        return $this->actionEditCompany();
    }
    public function actionEditCompany()
    {
        $id = $this->app->request->id;
        $fields = $this->modelUser->getFields('companies', 'add');
        $row = array();
        if ($id) {
            $this->page->c_id = $id;
            debug::add_log("<b>/*** Достаём Компанию ***/</b>");
            $row = $this->modelUser->GetByCond('companies', 'modify', array('id' => $id));
        }
        $this->page->CAction = 'edit';
        $this->page->dataBlock = 'companies';
        $dataPost = array_merge($row, $_POST);
        $this->loadForm('modify', $fields, $dataPost);
        if (!empty($_POST) && $this->form('modify')->validate($this->modelUser)) {
            $data = $this->form('modify')->getData();

            $data['user_id'] = $this->user['id'];
            $data['created'] = date('Y-m-d H:i:s');
            $cond = $id ? array('id' => $id) : null;
            $new_id = $this->modelUser->Save('companies', $data, $cond);

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                $return_data['id'] =  $new_id;
                $return_data['name'] = $data['name'];
                echo json_encode($return_data);
                exit;
            }
            else{
                header("Location: /cabinet/companies/");
                exit;
            }
        } else if(!empty($_POST) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $return_data['errors'] = $this->form('modify')->getErrors();

            echo json_encode($return_data);
            exit;
        }
        else{
            $this->page->CErrors = $this->form('modify')->getErrors();
        }

        if(count($this->page->meta) < 2) {
            $text = 'ЛК - '.($id ? 'редактирование компании "'.$row['name'].'"' : 'добавление компании');
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = $text;
            $this->page->meta = $meta_tags;
        }
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $this->app->contentType = 'application/json';
            $data['html'] =  $this->renderView('cabinet_companies_edit'); //имя файла, имя папки
            echo json_encode($data);
        }
        else{
            $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
            $this->loadView('main', null);
        }
    }

    public function actionShowCompany()
    {
        $id = $this->app->request->id;
        if ($id) {
            $this->page->CAction = 'show';
            $this->page->dataBlock = 'companies';
            $fields = $this->modelUser->getFields('companies', 'view');
            $titles = $this->modelUser->getTitles('companies', 'view');
            $data = $this->modelUser->GetByCond('companies', $this->modelUser->getFieldsNames('companies', 'view'), array('id' => $id));
            $this->page->fields = $fields;
            $this->page->titles = $titles;
            $this->page->data = $data;

            if(count($this->page->meta) < 2) {
                $text = 'ЛК - '.($id ? 'просмотр компании "'.$data['name'].'"' : 'добавление компании');
                $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = $text;
                $this->page->meta = $meta_tags;
            }

            $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
            $this->loadView('main', null);
        } else {
            header("Location: /cabinet/companies/");
            exit;
        }
    }

    public function actionDeleteCompany()
    {
        $id = $this->app->request->id;
        if ($id) {
            $this->modelUser->Delete('companies', array('id' => $id, 'user_id' => $this->user['id']));
        }
        header("Location: /cabinet/companies/");
        exit;
    }

    /***************** Заявки *********************/
    public function actionDownload_file()
    {
        try {
            if (!isset($_GET['path']) || empty($_GET['path'])){
                throw new Exception('Не указан путь к файлу.');
            }

            $url = 'http://twt-erp.twtconsult.ru/site/download/path/'.$_GET['path'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERPWD, "twtuser:UZk0h8cwwt");
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content = curl_exec($ch);
            curl_close($ch);

            if ($content === false || stripos($content, 'NotFound') === 0){
                throw new Exception('Ошибка при получении файла.');
            }
            $filename = time().'.pdf';
            header('Set-Cookie: fileDownload=true; path=/');
            header('Cache-Control: max-age=60, must-revalidate');
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Length: ' . strlen($content));
            echo $content;

        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function actionOrders()
    {
        $this->page->dataBlock = 'orders';
        $documents = $this->getAllDocuments();
        $this->page->orders = $documents;

        if(count($this->page->meta) < 2) {
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = 'ЛК - Заявки';
            $this->page->meta = $meta_tags;
        }
        Zf::addJS('cabinet_orders', '/public/zf/js/jquery.fileDownload.js');

        $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки

        $this->loadView('main', null);
    }

    private function getAllDocuments(){
        $data = array();
        $account_reqs = $this->model('account_req')->getList('account_req', 'cabinet', array('where' => array('user_id' => $this->user['id']), 'order' => array('id' => 'DESC')));
        $transport_reqs = $this->model('transport_req')->getList('transport_req', 'cabinet', array('where' => array('user_id' => $this->user['id']), 'order' => array('id' => 'DESC')));
        $entity_reqs = $this->model('entity_req')->getList('entity_req', 'cabinet', array('where' => array('user_id' => $this->user['id']), 'order' => array('id' => 'DESC')));

        $calcs = $this->getCalcs();
        var_dump($calcs);die;

        if (!empty($account_reqs)) {
            foreach($account_reqs as &$account_req) {
                $showCond = array('where' => array('accounts.account_req_id' => $account_req['id']));
                $account_req['banks'] = $this->model('account_req')->getList('accounts', 'cabinet', $showCond);
            }
        }
        if (!empty($account_reqs)) {
            foreach($account_reqs as &$account_req) {
                $showCond = array('where' => array('accounts.account_req_id' => $account_req['id']));
                $account_req['banks'] = $this->model('account_req')->getList('accounts', 'cabinet', $showCond);
            }
        }
        //debug::dump($calcs);
        $data['account'] = $account_reqs;
        $data['entity'] = $entity_reqs;
        $data['transport'] = $transport_reqs;
        $data['calcs'] = $calcs;

        return $data;
    }

    public function actionShowOrder()
    {
        $id = $this->app->request->id;
        $type = $this->app->request->type;
        $types = array('account', 'entity', 'transport');
        $this->page->CAction = 'show';
        $this->page->dataBlock = 'orders';
        if ($id && in_array($type, $types)) {
            $fields = $this->model($type.'_req')->getFields($type.'_req', 'showorder');
            $titles = $this->model($type.'_req')->getTitles($type.'_req', 'showorder');
            $data = $this->model($type.'_req')->GetByCond($type.'_req', $this->model($type.'_req')->getFieldsNames($type.'_req', 'showorder'), array($type.'_req.id' => $id, $type.'_req.user_id' => $this->user['id']));

            if ($type == 'account') {
                $showCond = array('where' => array('accounts.account_req_id' => $id));
                $data['banks'] = $this->model('account_req')->getList('accounts', 'cabinet', $showCond);
            }
            $this->page->fields = $fields;
            $this->page->titles = $titles;
            $this->page->data = $data;

        } elseif ($id && $type == 'calcs') {
            $calc = $this->getCalcs($id);
            //debug::dump($calc);
            if (!empty($calc)) {
                $calc['id'] = $this->app->request->id;
                $this->page->NumberOfSeatMeasure = $this->model('siteusers')->getSeatMeasures($this->page->settings);
                $tmps = $this->model('siteusers')->getCountries($this->page->settings);
                $countries = array();
                if (!empty($tmps)) {
                    foreach($tmps as $tmp) {
                        $countries[$tmp->id] = $tmp->name;
                    }
                }
                $transport = array(
                    '' => 'Не выбран',
                    '30' => 'Автодорожный транспорт, за исключением транспортных средств, указанных под кодами 31, 32',
                    '80' => 'Внутренний водный транспорт',
                    '40' => 'Воздушный транспорт',
                    '20' => 'Железнодорожный транспорт',
                    '10' => 'Морской/речной транспорт',
                    '50' => 'Почтовое отправление',
                );
                foreach($calc['transports'] as &$c) {
                    $cities = $this->model('siteusers')->getCitiesList($c['country'], $this->page->settings);
                    $c['city'] = $cities[$c['city']];
                    $c['transport'] = $transport[$c['transport']];
                }
                unset($c);
                $this->page->countries = $countries;
                $this->page->cities =
                $this->page->data = $calc;
            } else {
                header("Location: /cabinet/orders");
            }

        } else {
            header("Location: /cabinet/orders");
            exit;
        }
        if(count($this->page->meta) < 2) {
            $text = 'ЛК - просмотр заявки';
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = $text;
            $this->page->meta = $meta_tags;
        }
        $this->page->content = $this->renderView('cabinet'); //имя файла, имя папки
        $this->loadView('main', null);
    }

    /*
     * Получение списка заявок
     */
    public function getCalcs($id = null) {
        $calc_reqs = $this->model('siteusers')->soap('GetOrderList', array('UserID' => $this->user['email']), false, $this->page->settings);

        $calcs = array();

        if (!empty($calc_reqs->return)) {
            //debug::dump($calc_reqs);
            $err = $this->getSoapError($calc_reqs->return);
            if (!$err) {
                $tmpcalcs = json_decode($calc_reqs->return, 1);
                //debug::dump($tmpcalcs);
                if (!empty($tmpcalcs)) {
                    foreach($tmpcalcs as $tmp) {
                        $calc = $this->model('siteusers')->soap('GetOrder', (array('NumberOrder' => key($tmp), 'DateOrder' => $tmp[key($tmp)])), false, $this->page->settings);
                        if (!empty($calc->return)) {
                            $calc = json_decode($calc->return, 1);
                            if (isset($calc['link'])){
                                $calc['link'] = strtr(base64_encode(addslashes(gzcompress(serialize($calc['link']),9))), '+/=', '-_,');
                            }
                        }
                        $calcs[(int)key($tmp)] = $calc;
                    }
                }
            }
            krsort($calcs);
        }
        return ($id) ? (isset($calcs[$id]) ? $calcs[$id] : null) : $calcs;
    }

    public function getSoapError($data) {
        $error_order = false;
        if (!empty($data)) {
            preg_match_all('~(error)~', $data, $match);
            if (!empty($match[0])){
                $error_order = true;
            }
        } else {
            $error_order = true;
        }
        return $error_order;
    }

}
?>