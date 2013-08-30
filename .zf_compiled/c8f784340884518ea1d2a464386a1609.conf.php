<?php
$conf = array (
  'tables' => 
  array (
    'calculator_req' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'unsigned' => 1,
          'auto_increment' => 1,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'Номер',
          ),
        ),
        'req_num' => 
        array (
          'type' => 'tinytext',
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Номер заявки',
          ),
        ),
        'req_status' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отправлено',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
        'tnved' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'radio',
            'title' => 'Способ выбора товаров',
            'htmltype' => 'radio',
            'req' => 1,
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'yes' => 'По кодам ТНВЭД',
              'no' => 'По кодам категорий',
            ),
          ),
        ),
        'created' => 
        array (
          'type' => 'date',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'date',
            'req' => 1,
            'title' => 'Дата заявки',
          ),
        ),
        'contact' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Контактное лицо',
          ),
        ),
        'phone' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Контактный телефон',
          ),
        ),
        'mail' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'mail',
            'req' => 1,
            'title' => 'Контактный e-mail',
          ),
        ),
        'bank_id' => 
        array (
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбран',
            'title' => 'Банк',
            'req' => 1,
          ),
        ),
        'currency' => 
        array (
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбрана',
            'req' => 1,
            'title' => 'Валюта',
          ),
        ),
        'user_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Пользователь',
          ),
        ),
        'summ' => 
        array (
          'type' => 'int',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'Стоимость',
            'attrs' => 
            array (
              'maxlength' => 9,
            ),
          ),
        ),
        'codes' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'codes',
            'fields' => 
            array (
              0 => 'id',
              1 => 'name',
            ),
            'use_ref' => 'orders2codes',
          ),
          'am' => 
          array (
            'type' => 'tselect',
            'url' => '/getCodes/',
            'l2sr' => 4,
            'title' => 'Код',
            'field_name' => 'title',
            'title_field' => 'title',
            'attrs' => 
            array (
              'maxlength' => 10,
            ),
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'foreign' => 
      array (
        'bank' => 
        array (
          'table' => 'banks',
          'field' => 'title',
          'use_ref' => 'accounts2banks',
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'req_num',
          3 => 'req_status',
          4 => 'contact',
          5 => 'phone',
          6 => 'mail',
          7 => 'turnover',
          8 => 'sources',
          9 => 'own_sources',
        ),
        'show' => 
        array (
          0 => 'created',
          1 => 'req_num',
          2 => 'req_status',
          3 => 'contact',
          4 => 'phone',
          5 => 'mail',
          6 => 'turnover',
          7 => 'country_source',
          8 => 'country_receiver',
          9 => 'sources',
          10 => 'own_sources',
        ),
        'modify' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'contact',
          3 => 'phone',
          4 => 'mail',
          5 => 'turnover',
          6 => 'country_receiver',
          7 => 'country_source',
          8 => 'sources',
          9 => 'own_sources',
        ),
        'add' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'contact',
          3 => 'phone',
          4 => 'mail',
          5 => 'turnover',
          6 => 'country_source',
          7 => 'country_receiver',
          8 => 'sources',
          9 => 'own_sources',
        ),
        'site_form' => 
        array (
          0 => 'tnved',
          1 => 'currency',
          2 => 'codes',
          3 => 'summ',
        ),
        'site_form_check' => 
        array (
          0 => 'contact',
          1 => 'phone',
          2 => 'mail',
          3 => 'turnover',
          4 => 'country_source',
          5 => 'country_receiver',
          6 => 'sources',
          7 => 'own_sources',
        ),
        'site_mail' => 
        array (
          0 => 'contact',
          1 => 'phone',
          2 => 'mail',
          3 => 'turnover',
          4 => 'country_source',
          5 => 'country_receiver',
          6 => 'sources',
          7 => 'own_sources',
        ),
        'cabinet' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'turnover',
        ),
        'showorder' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'contact',
          3 => 'phone',
          4 => 'mail',
          5 => 'turnover',
          6 => 'country_source',
          7 => 'country_receiver',
          8 => 'sources',
          9 => 'own_sources',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'currencies' => 
    array (
      'dont_install' => 1,
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'auto_increment' => 1,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
          ),
        ),
        'title' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Название',
          ),
        ),
        'pos' => 
        array (
          'type' => 'int',
          'length' => 10,
          'unsigned' => 1,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'htmltype' => 'hidden',
          ),
        ),
        'code' => 
        array (
          'type' => 'varchar',
          'length' => '255',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Код',
            'trimNE' => 'Поле "Код" не должно быть пустым',
          ),
        ),
        'active' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'yes',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'checkbox',
            'title' => 'Отображать на сайте',
            'otitle' => 'Отображать на сайте',
            'default' => 'yes',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'tnved' => 
    array (
      'fields' => 
      array (
        'code' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Код',
          ),
        ),
        'title' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Название',
          ),
        ),
      ),
      'table' => 
      array (
        'KEYS' => 
        array (
          'code' => 
          array (
            0 => 'code',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
  'mail' => 
  array (
    'message_accounts' => 
    array (
      'from' => 'no_reply@twt.ru',
      'subject' => 'Новая заявка на юр. лицо № [req_id]',
      'type' => 'text/html',
      'message' => '<p>Здравствуйте</p>
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
<br>Источники происхождения ДС: [sources]',
    ),
    'message_admin' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => 'Поступила заявка на открытие счета № [req_id]',
      'type' => 'text/html',
      'message' => '<p>[NO_REST]</p>
<p>Поступила заявка на открытие счета № [req_id]</p> <br />
Номер заявки: [req_id] <br />
Дата заявки: [created] <br />
Контактное лицо: [contact] <br />
Контактный телефон: [phone] <br />
Контактный e-mail: [mail] <br />
Счета: [accounts] <br />
Страны источники: [country_source] <br />
Страны приемники: [country_receiver] <br />
Источники происхождения ДС: [sources] <br />
Свои источники происхождения ДС: [own_sources]
<div>Строка 1С: [json]</div>',
    ),
    'repl' => 
    array (
      'site_name' => 'TWT',
    ),
    'date_format' => 'H:i:s d.m.Y',
  ),
);
?>