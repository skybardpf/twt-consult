<?php
$conf = array (
  'tables' => 
  array (
    'entity_req' => 
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
            'title' => 'Статус',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'не отправлено',
              'yes' => 'отправлено',
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
        'jur_country_id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбрана',
            'title' => 'Юрисдикция',
            'req' => 1,
          ),
        ),
        'company_name' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Желательное название компании',
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
        'kind_activities' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'kind_activities',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'entity2kind_activities',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Род деятельности',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
          ),
        ),
        'own_kind_activities' => 
        array (
          'type' => 'text',
          'am' => 
          array (
            'type' => 'text',
            'title' => 'Свой род деятельности',
          ),
        ),
        'turnover' => 
        array (
          'type' => 'int',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'Ожидаемый оборот',
            'attrs' => 
            array (
              'maxlength' => 9,
            ),
          ),
        ),
        'currency_id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбрана',
            'title' => 'Валюта',
            'req' => 1,
          ),
        ),
        'country_source' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'country_source',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'entity2country_source',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Страны источники входящих денежных переводов',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
            'alias' => 'country_source',
          ),
        ),
        'country_receiver' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'country_receiver',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'entity2country_receiver',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Страны назначения исходящих денежных переводов',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
            'alias' => 'country_receiver',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'foreign' => 
      array (
        'jurisdiction' => 
        array (
          'table' => 'countries',
          'field' => 'title',
          'use_ref' => 'entity2jur_countries',
          'am' => 'jur_country_id',
        ),
        'price_final' => 
        array (
          'table' => 'countries',
          'field' => 'price_final',
          'use_ref' => 'entity2jur_countries',
          'am' => 'jur_country_id',
        ),
        'currency' => 
        array (
          'table' => 'currencies',
          'field' => 'title',
          'use_ref' => 'entity2currencies',
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбрана',
            'title' => 'Валюта',
          ),
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
          5 => 'mail',
          6 => 'jur_country_id',
          7 => 'company_name',
          8 => 'kind_activities',
          9 => 'own_kind_activities',
          10 => 'turnover',
          11 => 'currency_id',
        ),
        'show' => 
        array (
          0 => 'created',
          1 => 'req_num',
          2 => 'req_status',
          3 => 'contact',
          4 => 'mail',
          5 => 'jur_country_id',
          6 => 'company_name',
          7 => 'kind_activities',
          8 => 'own_kind_activities',
          9 => 'turnover',
          10 => 'currency_id',
          11 => 'country_source',
          12 => 'country_receiver',
        ),
        'modify' => 
        array (
          0 => 'req_num',
          1 => 'contact',
          2 => 'mail',
          3 => 'jur_country_id',
          4 => 'company_name',
          5 => 'kind_activities',
          6 => 'own_kind_activities',
          7 => 'turnover',
          8 => 'currency_id',
          9 => 'country_source',
          10 => 'country_receiver',
        ),
        'add' => 
        array (
          0 => 'req_num',
          1 => 'contact',
          2 => 'mail',
          3 => 'jur_country_id',
          4 => 'company_name',
          5 => 'kind_activities',
          6 => 'own_kind_activities',
          7 => 'turnover',
          8 => 'currency_id',
          9 => 'country_source',
          10 => 'country_receiver',
        ),
        'site_form' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'jur_country_id',
          3 => 'company_name',
          4 => 'kind_activities',
          5 => 'own_kind_activities',
          6 => 'turnover',
          7 => 'currency_id',
          8 => 'country_source',
          9 => 'country_receiver',
        ),
        'site_mail' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'jur_country_id',
          3 => 'jurisdiction',
          4 => 'company_name',
          5 => 'kind_activities',
          6 => 'own_kind_activities',
          7 => 'turnover',
          8 => 'currency_id',
          9 => 'currency',
          10 => 'country_source',
          11 => 'country_receiver',
        ),
        'cabinet' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'jurisdiction',
          3 => 'company_name',
          4 => 'kind_activities',
          5 => 'price_final',
        ),
        'showorder' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'contact',
          3 => 'mail',
          4 => 'jurisdiction',
          5 => 'company_name',
          6 => 'kind_activities',
          7 => 'own_kind_activities',
          8 => 'turnover',
          9 => 'currency',
          10 => 'country_source',
          11 => 'country_receiver',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'countries' => 
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
        'active' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'yes',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отображать на сайте',
            'htmltype' => 'checkbox',
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
    'entity2kind_activities' => 
    array (
      'fields' => 
      array (
        'entity_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на юр. лицо',
          ),
        ),
        'kind_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Род деятельности',
          ),
        ),
      ),
      'table' => 
      array (
        'UNIQUE' => 
        array (
          'entity_kind_activities' => 
          array (
            0 => 'entity_id',
            1 => 'kind_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'entity2country_source' => 
    array (
      'fields' => 
      array (
        'entity_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на юр. лицо',
          ),
        ),
        'country_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Страны источники входящих денежных переводов',
          ),
        ),
      ),
      'table' => 
      array (
        'UNIQUE' => 
        array (
          'entity_country_source' => 
          array (
            0 => 'entity_id',
            1 => 'country_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'entity2country_receiver' => 
    array (
      'fields' => 
      array (
        'entity_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на юр. лицо',
          ),
        ),
        'country_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Страны назначения исходящих денежных переводов',
          ),
        ),
      ),
      'table' => 
      array (
        'UNIQUE' => 
        array (
          'entity_country_source' => 
          array (
            0 => 'entity_id',
            1 => 'country_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'kind_activities' => 
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
  ),
  'refs' => 
  array (
    'entity2jur_countries' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'entity_req' => 'jur_country_id',
        'countries' => 'id',
        'alias' => 'jur_countries',
      ),
    ),
    'entity2currencies' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'entity_req' => 'currency_id',
        'currencies' => 'id',
      ),
    ),
    'entity2kind_activities' => 
    array (
      'virtual' => 1,
      'join' => 'left outer',
      'type' => 'N-M',
      'tables' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'table' => 'entity_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'entity2kind_activities',
            'field' => 'entity_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'entity2kind_activities',
            'field' => 'kind_id',
          ),
          1 => 
          array (
            'table' => 'kind_activities',
            'field' => 'id',
          ),
        ),
      ),
    ),
    'entity2country_source' => 
    array (
      'virtual' => 1,
      'join' => 'left outer',
      'type' => 'N-M',
      'tables' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'table' => 'entity_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'entity2country_source',
            'field' => 'entity_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'entity2country_source',
            'field' => 'country_id',
          ),
          1 => 
          array (
            'table' => 'countries',
            'field' => 'id',
            'alias' => 'country_source',
          ),
        ),
      ),
    ),
    'entity2country_receiver' => 
    array (
      'virtual' => 1,
      'join' => 'left outer',
      'type' => 'N-M',
      'tables' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'table' => 'entity_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'entity2country_receiver',
            'field' => 'entity_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'entity2country_receiver',
            'field' => 'country_id',
          ),
          1 => 
          array (
            'table' => 'countries',
            'field' => 'id',
            'alias' => 'country_receiver',
          ),
        ),
      ),
    ),
  ),
  'mail' => 
  array (
    'message_entity' => 
    array (
      'from' => 'no_reply@twt.ru',
      'subject' => 'Новая заявка на юр. лицо № [req_id]',
      'type' => 'text/html',
      'message' => '<p>Здравствуйте</p>
<br>Вы подали заявку на сайте [site_name]
<br>Номер заявки: [req_id]
<br>Дата заявки: [created]
<br>Контактное лицо: [contact]
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
    'message_admin' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => 'Поступила заявка на юр. лицо № [req_id]',
      'type' => 'text/html',
      'message' => '<p>[NO_REST]</p>
<p>Поступила заявка на юр. лицо № [req_id]</p> <br />
Номер заявки: [req_id] <br />
Дата заявки: [created] <br />
Контактное лицо: [contact] <br />
Контактный e-mail: [mail] <br />
Юрисдикция: [jurisdiction] <br />
Желательное название компании: [company_name] <br />
Род деятельности: [kind_activities] <br />
Свой род деятельности: [own_kind_activities] <br />
Ожидаемый оборот: [turnover] <br />
Валюта: [currency] <br />
Страны источники: [country_source] <br />
Страны приемники: [country_receiver]
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