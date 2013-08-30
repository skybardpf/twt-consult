<?php
class ContentController extends Site_Content_Controller
{
    public function actionDefault(){
        $page_content = parent::actionDefault(0);

        if ($page_content && $page_content['id'] == 1) {
            //блок промо-баннер
            $this->page->promo_banners = $this->model('announcies', 'announcies')->getList(
                'announcies',
                $this->model('announcies', 'announcies')->getFieldsNames('announcies', 'site_list'),
                array(
                    'where' => array(
                        'active' => 'yes',
                        'type' => 'promo'
                    ),
                    'order' => array('rand')//'pos' => 'ASC')
                )
            );
        }
        $this->loadView('main', null);
    }

    public function actionCall_back() {
        header('Content-Type: application/json; charset=utf-8');
        $ret = array();
        $callback_model = $this->model('callback', 'callback');
        $callback_model->initValues(array('time_id'));
        $data = isset($_POST) ? $_POST : array();
        $elements = $callback_model->getFields('callback', 'site_form');
        $this->loadForm('callback', $elements, $data);
        if (isset($_POST) && $_POST) {
            if($this->form('callback')->validate($this->model('callback', 'callback'))) {
                $data = $this->form('callback')->getData();
                $data['created'] = date('Y-m-d H:i:s');
                $data['status'] = 'new';
                $callback = $callback_model->GetByCond('callback', array('id'), array('where' => array('created' => $data['created'], 'contact' => $data['contact'], 'time_id' => $data['time_id'], 'phone' => $data['phone'], 'status' => $data['status'])));
                if (!$callback) {
                    $callback_id = $callback_model->Save('callback', $data);
                    
                    if ($this->page->settings['email_to_callback']) {
                        $mail['date'] = date('d.m.Y', strtotime($data['created'].' +3 hours'));
                        $mail['time'] = date('H:i', strtotime($data['created'].' +3 hours'));
                        $mail['name'] = $data['contact'];
                        $time = $callback_model->GetByCond('times', array('title'), array('id' => $data['time_id']), 1);
                        $mail['hour'] = $time['title'];
                        $mail['phone'] = $data['phone'];
                        $this->model('callback')->SendMail($this->page->settings['email_to_callback'], $mail, 'callback');
                    }
                    $this->page->success = true;
                } else {
                    $this->page->success = false;
                    $this->page->repeated = true;
                }
            } else {
                $this->page->calerrors = $this->form('callback')->getErrors();
                $ret['success'] = false;
            }
        }
        $ret['message'] = $this->renderView('call_back', null);

        die(json_encode($ret));
    }

    public function actionUpdate_quotations() {
        $ids = $this->model('countries')->getValues('title', 'id', 'countries', array('order' => array('rand')));
        foreach ($ids as $title=>$id) {
            $this->model('countries')->Update('countries', array('quotation' => (mt_rand (0, 1)) ? 'red' : 'green'), array('id' => $id));
            echo 'Обновление страны:'.$title;
            echo '<br>'.'\n';
        }
    }

    public function actionGetprice() {
        if (!empty($_POST['id'])) {
            header('Content-type: application/json');
            $cur = $this->model('countries')->GetByCond('countries', array('price'), array('id' => $_POST['id']));
            echo json_encode($cur['price']);
            exit;
        }
    }

    public function actionBank_change() {
        if ($this->app->request->ajax == 1) {
            $values = array();
            $price = null;
            if (!empty($_POST)){
                //заполняем фильтр
                if(!empty($_POST['bank_id'])){
                    $bank_id = $_POST['bank_id'];
                    $values = $this->model('banks', 'banks')->initCurrencyValues($bank_id);
                    $price = $this->model('banks', 'banks')->GetByCond('banks', array('price_final'), $bank_id, 1);
                    $price = (!empty($price['price_final'])) ? $price['price_final'] : null;
                }
            }
            if ($this->app->request->ajax) {
                $ret['values'] = $values;
                $ret['price'] = $price;
                echo(json_encode($ret)); exit;
            }
        } else {
            return $this->actionNotFound('main');
        }
        //$this->loadView('main', null);
    }

    /*
     * Регистрация / Авторизация
     */
    public function actionCheckAuth() {
        //if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        $this->app->contentType = 'application/json';
        if (!$this->app->session->siteuser) {
            $model_user = $this->model('siteusers', 'siteusers');
            $post_auth = (!empty($_POST['auth'])) ? $_POST['auth'] : array();
            //debug::dump($post_data);
            $auth_fields = $model_user->getFields('siteusers', 'site_authorize');
            $this->loadForm('authorize', $auth_fields, $post_auth);
            if (!empty($post_auth) && $this->form('authorize')->validate($model_user)) {
                $data = $this->form('authorize')->getData();

                $site_user = $model_user->GetByCond(
                    'siteusers', array(),
                    array('where' => array('email' => $data['email'], 'password' => $data['password']))
                );
                if (!empty($site_user)) {
                    $this->app->session->siteuser = $site_user;
                    $ret['siteuser'] = json_encode($site_user);
                    //$ret['link'] = '/cabinet';
                } else {
                    $this->page->form_auth_errors = array('Неверный логин или пароль.');
                }
            } elseif (!empty($post_auth)) {
                $this->page->form_auth_errors = $this->form('authorize')->getErrors();
            }
            $this->page->logged_site_user = $this->app->session->siteuser;

            $post_reg = (!empty($_POST['registration'])) ? $_POST['registration'] : array();
            $reg_fields = $model_user->getFields('siteusers', 'site_reg');
            $this->loadForm('registration', $reg_fields, $post_reg);
            if (!empty($post_reg) && $this->form('registration')->validate($model_user)) {
                $data = $this->form('registration')->getData();
                $siteusers = $model_user->GetByCond(
                    'siteusers', array(),
                    array(
                        'where' => array(
                            'email' => $data['email']
                        )
                    ), 1
                );
                if (!empty($siteusers)) {
                    $this->page->form_reg_errors = array("Пользователь с данным адресом почты есть в базе данных");
                } else {
                    // Символы, которые будут использоваться в пароле.
                    $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
                    // Количество символов в пароле.
                    $max=10;
                    // Определяем количество символов в $chars
                    $size=StrLen($chars)-1;
                    // Определяем пустую переменную, в которую и будем записывать символы.
                    $password=null;
                    // Создаём пароль.
                    while($max--) {
                        $password.=$chars[rand(0,$size)];
                    }
                    // Выводим созданный пароль.
                    $hash = $password;
                    $data['password'] = md5($password);
                    if ($userId = $model_user->Save('siteusers', $data)) {
                        $settings = $this->page->settings;
                        $model_user->SendMail($data['email'], array('name' => $data['name'], 'email' => $data['email'], 'pass' => $password), 'register');
                        if (!empty($settings['email_to_reg'])) {
                            $model_user->SendMail($settings['email_to_reg'], array('name' => $data['name'], 'email' => $data['email']), 'register_admin');
                        }
                        $site_user = $model_user->GetByCond(
                            'siteusers', 'user',
                            array(
                                'where' => array(
                                    'email' => $data['email']
                                )
                            ), 1
                        );
                        $this->app->session->siteuser = $site_user;
                        $str = array();
                        foreach($site_user as $k => $v) {
                            $str[] = "user[{$k}]={$v}";
                        }
                        $ret['siteuser'] = implode('&', $str);
                        //$ret['link'] = '/cabinet';
                    } else {
                        $this->page->form_reg_errors = array("Произошла не известная ошибка");
                    }

                    $this->page->login_error = true;
                }
            } elseif (!empty($post_reg)) {
                $this->page->form_reg_errors = $this->form('registration')->getErrors();
            }
        } else {
            $this->app->session->siteuser = null;
        }

        //$ret['pass'] = $hash;
        $ret['message'] = $this->renderView('authorize', null);
        die(json_encode($ret));
        /*$this->page->content = $this->renderView('authorize', null);
        $this->loadView('main', null);*/
        /*} else {
            header('Location: /');
            exit;
        }*/
    }

    public function actionRemindPass(){
        $this->app->contentType = 'application/json';
        if(isset($_POST['mail']) && $_POST['mail'] != ''){
            $mail = $_POST['mail'];
            $model_user = $this->model('siteusers', 'siteusers');
            // В БД ищем автора с такой почтой
            $usr = $model_user->GetByCond('siteusers', array('id', 'email'), array('where' => array('email' => $mail)));
            if(!$usr) {
                echo json_encode('not_found');
                exit;
            }
            else{
                $key_date = date('Y-m-d H:i:s');
                $uniq_key = md5($usr['id'].$mail.rand(0, 50000).time()).$usr['id'].md5($key_date.rand(0, 50000).time());
                $success = $model_user->Save('siteusers', array('uniq_key' => $uniq_key, 'key_date' => $key_date), array('id' => $usr['id']));
                if($success > 0) {
                    // Высылаем на почту ссылку на смену пароля
                    $link = 'http://'.$_SERVER['HTTP_HOST'].'/cabinet/?'.'key='.$uniq_key.'&mail='.$usr['email'];
                    if(!empty($mail))
                        $model_user->SendMail($mail, array('link' => $link, 'host' => $_SERVER['HTTP_HOST']), 'remind_pass');
                    echo json_encode('sended');
                } else {
                    echo json_encode('undefined_error');
                }
            }
        }
        else{
            echo json_encode('not_found');
            exit;
        }
    }

    public function actionLogout() {
        $this->app->session->siteuser = null;
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }


}