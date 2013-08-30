<?php
$conf = array (
  'app' => 'twt',
  'title' => 'twt_title',
  'charset' => 'utf-8',
  'load_named_conf' => 0,
  'db_prefix' => '',
  'jquery_version' => '-1.8.2.min',
  'mvc' => 
  array (
    'dirs' => 
    array (
      'models' => 'models',
      'controllers' => 'controllers',
      'views' => 'views',
    ),
    'use_subdirs' => 
    array (
      'controllers' => 0,
      'models' => 0,
      'views' => 1,
    ),
  ),
  'views' => 
  array (
    'forms' => 
    array (
      'label' => '<label for="{id}">{title}</label>',
    ),
  ),
  'use_smarty' => 1,
  'smarty' => 
  array (
    'compile_dir' => '.zf_compiled/',
  ),
  'kcaptcha' => 
  array (
    'bgcolor' => '255-255-255',
  ),
  'page' => 
  array (
    'extract_variables' => 1,
    'extract_forms' => 1,
  ),
  'default_controller' => 'content',
  'has_common_controller' => 1,
  'vars_keys' => 
  array (
    0 => 'id',
    1 => 'pid',
    2 => 'page',
    3 => 'pos',
    4 => 'application',
    5 => 'god_mode',
    6 => 'sort',
    7 => 'dir',
    8 => 'ajax',
  ),
  'session' => 
  array (
    'save_path' => '.zf_tmp',
    'autostart' => 1,
    'lifetime' => 0,
    'update_lifetime' => 0,
    'name' => 'twt_session',
  ),
  'run_at' => 
  array (
    'local' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'local.twt.ru',
        ),
      ),
      'mode' => 'development',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'server',
      'db_name' => 'twt',
      'db_user' => 'root',
      'db_pass' => 'ferthuk',
      'db_sql_mode' => '',
    ),
    'roma' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'twt.romaaa',
        ),
      ),
      'mode' => 'development',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'localhost',
      'db_name' => 'twt',
      'db_user' => 'root',
      'db_pass' => '',
      'db_sql_mode' => '',
    ),
    'yury' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'yury.twt.ru',
        ),
      ),
      'mode' => 'development',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'localhost',
      'db_name' => 'twt',
      'db_user' => 'root',
      'db_pass' => 729137,
      'db_sql_mode' => '',
    ),
    'anna' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'anna.twt.ru',
        ),
      ),
      'mode' => 'development',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'localhost',
      'db_name' => 'twt',
      'db_user' => 'root',
      'db_pass' => 'zK1dQp1988',
      'db_sql_mode' => '',
    ),
    'demo' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'twt.artektiv.ru',
        ),
      ),
      'mode' => 'production',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'localhost',
      'db_name' => 'twt',
      'db_user' => 'acdbuser',
      'db_pass' => 'ZCHGiwj7',
    ),
    'skybardpf' => 
    array (
      'cond' => 
      array (
        'host' => 
        array (
          0 => 'twt-consult',
        ),
      ),
      'mode' => 'production',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'localhost',
      'db_name' => 'ioffic_db1',
      'db_user' => 'root',
      'db_pass' => 123456,
    ),
    'remote' => 
    array (
      'cond' => 
      array (
      ),
      'mode' => 'production',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'sql171.your-server.de',
      'db_name' => 'ioffic_db1',
      'db_user' => 'ioffic_1',
      'db_pass' => 'F74vJhdi',
    ),
    'default' => 
    array (
      'cond' => 
      array (
      ),
      'mode' => 'production',
      'db_engine' => 'mysql',
      'db_charset' => 'utf-8',
      'db_use_pconnection' => 0,
      'db_host' => 'sql171.your-server.de',
      'db_name' => 'ioffic_db1',
      'db_user' => 'ioffic_1',
      'db_pass' => 'F74vJhdi',
    ),
  ),
  'modes' => 
  array (
    'development' => 
    array (
      'cond' => 
      array (
        'local' => '*',
        'skybardpf' => '*',
        'yury' => '*',
        'anna' => '*',
        'roma' => '*',
        'demo' => '*',
      ),
      'db_debug' => 
      array (
        'store_queries' => 1,
        'store_raw_queries' => 1,
        'store_results' => 1,
        'store_caller' => 1,
        'store_times' => 1,
        'times_precision' => 5,
      ),
      'debug' => 
      array (
        'error_reporting' => 'E_ALL',
        'display_errors' => 1,
        'log_errors' => 1,
        'store_codesniplets' => 1,
      ),
      'smarty' => 
      array (
        'debug' => 0,
      ),
    ),
    'debug' => 
    array (
      'cond' => 
      array (
        'remote' => 
        array (
          'remote_ip' => '83.229.142.164',
        ),
        'default' => 
        array (
          'remote_ip' => '83.229.142.164',
        ),
      ),
      'db_debug' => 
      array (
        'store_queries' => 1,
        'store_raw_queries' => 1,
        'store_results' => 1,
        'store_caller' => 1,
        'store_times' => 1,
        'times_precision' => 5,
      ),
      'debug' => 
      array (
        'error_reporting' => 'E_ALL',
        'display_errors' => 1,
        'log_errors' => 1,
        'store_codesniplets' => 1,
      ),
      'smarty' => 
      array (
        'debug' => 0,
      ),
    ),
    'console' => 
    array (
      'db_debug' => 
      array (
        'store_queries' => 0,
        'store_raw_queries' => 0,
        'store_results' => 0,
        'store_caller' => 0,
        'store_times' => 0,
        'times_precision' => 0,
      ),
      'debug' => 
      array (
        'error_reporting' => 'E_ALL',
        'display_errors' => 1,
        'log_errors' => 1,
        'store_codesniplets' => 0,
        'disabled' => 1,
      ),
      'smarty' => 
      array (
        'debug' => 0,
      ),
    ),
    'production' => 
    array (
      'cond' => 
      array (
        'remote' => '*',
      ),
      'db_debug' => 
      array (
        'store_queries' => 0,
        'store_raw_queries' => 0,
        'store_results' => 0,
        'store_caller' => 0,
        'store_times' => 0,
        'times_precision' => 0,
      ),
      'debug' => 
      array (
        'error_reporting' => 'E_ALL',
        'display_errors' => 0,
        'log_errors' => 1,
        'store_codesniplets' => 0,
        'disabled' => 1,
      ),
      'smarty' => 
      array (
        'debug' => 0,
      ),
    ),
  ),
  'settings' => 
  array (
    'counters' => 
    array (
      'title' => 'Счетчики',
      'type' => 'raw_text',
    ),
    'error_404' => 
    array (
      'title' => 'Текст ошибки 404',
      'type' => 'raw_text',
    ),
    'adress' => 
    array (
      'title' => 'Адрес компании',
      'type' => 'raw_text',
    ),
    'phone' => 
    array (
      'title' => 'Телефоны компании',
      'type' => 'raw_text',
    ),
    'banner_period' => 
    array (
      'title' => 'Периодичность смены баннеров',
      'type' => 'string',
    ),
    'news_cnt' => 
    array (
      'title' => 'Количество новостей на страницу',
      'type' => 'string',
    ),
    'entity_url' => 
    array (
      'title' => 'URL формы заявки на юр. лицо',
      'type' => 'text',
    ),
    'entity_text' => 
    array (
      'title' => 'Текст для формы заявки на юр. лицо',
      'type' => 'ckhtml',
    ),
    'account_url' => 
    array (
      'title' => 'URL формы заявки на открытие счёта',
      'type' => 'text',
    ),
    'account_text' => 
    array (
      'title' => 'Текст для формы заявки на открытие счёта',
      'type' => 'ckhtml',
    ),
    'transport_url' => 
    array (
      'title' => 'URL формы заявки на услугу перевозки',
      'type' => 'text',
    ),
    'transport_text' => 
    array (
      'title' => 'Текст для формы заявки на услугу перевозки',
      'type' => 'ckhtml',
    ),
    'email_to_callback' => 
    array (
      'title' => 'Email для получения уведомлений о заказах обратного звонка с сайта',
      'type' => 'string',
    ),
    'email_to_ent' => 
    array (
      'title' => 'Email для получения уведомлений о новых заявках на регистрацию юр. лица с сайта',
      'type' => 'string',
    ),
    'email_to_acc' => 
    array (
      'title' => 'Email для получения уведомлений о новых заявках на открытие счёта с сайта',
      'type' => 'string',
    ),
    'email_to_transp' => 
    array (
      'title' => 'Email для получения уведомлений о новых заявках на транспортировку',
      'type' => 'string',
    ),
    'template_entity' => 
    array (
      'title' => 'Шаблон для письма заявки на юр. лицо:',
      'type' => 'placeholder',
    ),
    'from_entity' => 
    array (
      'title' => 'От',
      'type' => 'string',
      'default' => 'no_reply@twt.ru',
    ),
    'subject_entity' => 
    array (
      'title' => 'Тема',
      'type' => 'string',
      'default' => 'Новая заявка на юр. лицо № [req_id]',
    ),
    'type_entity' => 
    array (
      'title' => 'Тип текста',
      'type' => 'string',
      'default' => 'text/html',
    ),
    'message_entity' => 
    array (
      'title' => 'Письмо',
      'type' => 'html',
      'default' => '<p>Здравствуйте</p>
<br>Вы подали заявку на сайте [site_name]
<br>Номер заявки: [req_id]
<br>Дата заявки: [created]
<br>Контактное лицо: [contact]
<br>Контактный телефон: [phone]
<br>Контактный e-mail: [mail]
<br>Юрисдикция: [jurisdiction]
<br>Желательное название компании: [company_name]
<br>Род деятельности: [kind_activities]
<br>Свой род деятельности: [own_kind_activities]
<br>Ожидаемый оборот: [turnover]
<br>Валюта: [currency]
<br>Страны источники: [country_source]
<br>Страны приемники: [country_receiver]',
    ),
    'template_account' => 
    array (
      'title' => 'Шаблон для письма заявки на открытие счёта:',
      'type' => 'placeholder',
    ),
    'from_account' => 
    array (
      'title' => 'От',
      'type' => 'string',
      'default' => 'no_reply@twt.ru',
    ),
    'subject_account' => 
    array (
      'title' => 'Тема',
      'type' => 'string',
      'default' => 'Новая заявка на на открытие счёта № [req_id]',
    ),
    'type_account' => 
    array (
      'title' => 'Тип текста',
      'type' => 'string',
      'default' => 'text/html',
    ),
    'message_account' => 
    array (
      'title' => 'Письмо',
      'type' => 'html',
      'default' => '<p>Здравствуйте</p>
<br>Вы подали заявку на сайте [site_name]
<br>Номер заявки: [req_id]
<br>Дата заявки: [created]
<br>Контактное лицо: [contact]
<br>Контактный телефон: [phone]
<br>Контактный e-mail: [mail]
<br>Счета: [accounts]
<br>Ожидаемый оборот: [turnover]
<br>Страны источники: [country_source]
<br>Страны приемники: [country_receiver]
<br>Источники происхождения ДС: [sources]
<br>Свои источники происхождения ДС: [own_sources]',
    ),
    'template_transport' => 
    array (
      'title' => 'Шаблон для письма заявки на транспортировку:',
      'type' => 'placeholder',
    ),
    'from_transport' => 
    array (
      'title' => 'От',
      'type' => 'string',
      'default' => 'no_reply@twt.ru',
    ),
    'subject_transport' => 
    array (
      'title' => 'Тема',
      'type' => 'string',
      'default' => 'Новая заявка на транспортировку № [transp_id]',
    ),
    'type_transport' => 
    array (
      'title' => 'Тип текста',
      'type' => 'string',
      'default' => 'text/html',
    ),
    'message_transport' => 
    array (
      'title' => 'Письмо',
      'type' => 'html',
      'default' => '<p>Здравствуйте</p>
<br>Вы подали заявку на сайте [site_name]
<br>Номер заявки: [transp_id]
<br>Дата заявки: [created]
<br>Название компании: [company_name]
<br>Контактное лицо: [contact]
<br>Контактный телефон: [phone]
<br>Контактный e-mail: [mail]
<br>Комментарии и примечания: [comment]
<br>Вид перевозки: [type_trasport]
<br>Страна загрузки: [loading_country]
<br>Место таможенного оформления: [customs_place]
<br>Страна доставки: [delivery_country]
<br>Наименование груза: [cargo_name]
<br>Вес брутто: [weight]
<br>Объем: [volume]
<br>Стоимость груза: [cost]
<br>Валюта: [currency]
<br>Класс опасности (для опасных грузов): [danger_class]
<br>Требуемый тип п/с: [type_ps]
<br>Температурный режим (для грузов, требующих особых условий хранения): [temperature_mode]
<br>Необходимо страхование груза: [is_insurance]
<br>Таможенное оформление: [is_customs]
<br>Дополнительная информация о перевозке, пожелания: [transport_inform]
<br>Дополнительная информация о погрузке, пожелания: [loading_inform]',
    ),
    'settings_sitemap' => 
    array (
      'title' => 'Генерация sitemap.xml',
      'type' => 'link2smth',
      'value' => '/admin/services/getsitemap',
    ),
    'settings_countries' => 
    array (
      'title' => 'Анонс для списка стран',
      'type' => 'html',
    ),
    'settings_entity_text' => 
    array (
      'title' => 'Текст для указания стоимости в заявке на регистрацию компании',
      'type' => 'html',
    ),
    'set_account_text' => 
    array (
      'title' => 'Текст для указания стоимости в заявке на открытие счета',
      'type' => 'html',
    ),
    'server' => 
    array (
      'title' => 'Сервер WSDL',
      'type' => 'string',
    ),
    'login' => 
    array (
      'title' => 'Логин WSDL',
      'type' => 'string',
    ),
    'pass' => 
    array (
      'title' => 'Пароль WSDL',
      'type' => 'string',
    ),
    'calc_server' => 
    array (
      'title' => 'Сервер WSDL для калькулятора',
      'type' => 'string',
    ),
    'calc_login' => 
    array (
      'title' => 'Логин WSDL для калькулятора',
      'type' => 'string',
    ),
    'calc_pass' => 
    array (
      'title' => 'Пароль WSDL для калькулятора',
      'type' => 'string',
    ),
    'erp_server' => 
    array (
      'title' => 'Сервер WSDL ERP',
      'type' => 'string',
    ),
    'erp_login' => 
    array (
      'title' => 'Логин WSDL ERP',
      'type' => 'string',
    ),
    'erp_pass' => 
    array (
      'title' => 'Пароль WSDL ERP',
      'type' => 'string',
    ),
  ),
  'cms_menu' => 
  array (
    0 => 
    array (
      'title' => 'Страницы',
      'link' => 'content',
      'icon' => 'content',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => 'Показать страницы',
          'link' => 'content/list',
        ),
        1 => 
        array (
          'title' => 'Редактировать главную',
          'link' => 'content/modify/id/1/pid/1',
        ),
      ),
    ),
  ),
  'cms_smenu' => 
  array (
    0 => 
    array (
      'title' => 'Меню',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => 'Верхнее меню',
          'link' => 'menu',
        ),
        1 => 
        array (
          'title' => 'Нижнее меню',
          'link' => 'footer_menu',
        ),
      ),
    ),
    1 => 
    array (
      'title' => 'Справочники',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => 'Банки',
          'link' => 'banks',
        ),
        1 => 
        array (
          'title' => 'Валюта',
          'link' => 'currencies',
        ),
        2 => 
        array (
          'title' => 'Время',
          'link' => 'times',
        ),
        3 => 
        array (
          'title' => 'Источники происхождения ДС',
          'link' => 'sources',
        ),
        4 => 
        array (
          'title' => 'Роды деятельности',
          'link' => 'kind_activities',
        ),
        5 => 
        array (
          'title' => 'Страны',
          'link' => 'countries',
        ),
        6 => 
        array (
          'title' => 'Интересующие услуги',
          'link' => 'services/list_additional',
        ),
      ),
    ),
    2 => 
    array (
      'title' => 'Контент',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => '25 кадр',
          'link' => 'frames_25',
        ),
        1 => 
        array (
          'title' => 'Баннеры',
          'link' => 'announcies',
        ),
        2 => 
        array (
          'title' => 'Новости',
          'link' => 'news',
        ),
        3 => 
        array (
          'title' => 'Сервисы',
          'link' => 'services',
        ),
      ),
    ),
    3 => 
    array (
      'title' => 'Пользователи',
      'link' => 'siteusers',
    ),
    4 => 
    array (
      'title' => 'Заявки',
      'color' => '#f00',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => 'Открытие счета',
          'link' => 'account_req',
        ),
        1 => 
        array (
          'title' => 'Регистрация юр.лица',
          'link' => 'entity_req',
        ),
        2 => 
        array (
          'title' => 'Заявка на перевозку',
          'link' => 'transport_req',
        ),
      ),
    ),
    5 => 
    array (
      'title' => 'Обратный звонок',
      'link' => 'callback',
    ),
    6 => 
    array (
      'title' => 'Администраторы',
      'link' => 'users',
      'submenu' => 
      array (
        0 => 
        array (
          'title' => 'Добавить',
          'link' => 'users/add',
        ),
        1 => 'hr',
        2 => 
        array (
          'title' => 'Роли',
          'link' => 'users/list_roles',
        ),
        3 => 
        array (
          'title' => 'Добавить роль',
          'link' => 'users/add_role',
        ),
      ),
    ),
  ),
);
?>