<?php
$conf = array (
  'tables' => 
  array (
    'account_req' => 
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
        'currency_id' => 
        array (
          'am' => 
          array (
            'type' => 'select',
            'null' => 'Не выбрана',
            'title' => 'Валюта счета',
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
            'use_ref' => 'accounts2country_source',
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
            'use_ref' => 'accounts2country_receiver',
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
        'sources' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'sources',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'account2sources',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Источники происхождения ДС',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
          ),
        ),
        'own_sources' => 
        array (
          'type' => 'text',
          'am' => 
          array (
            'type' => 'text',
            'title' => 'Свои источники происхождения ДС',
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
          5 => 'mail',
          6 => 'turnover',
          7 => 'sources',
          8 => 'own_sources',
        ),
        'show' => 
        array (
          0 => 'created',
          1 => 'req_num',
          2 => 'req_status',
          3 => 'contact',
          4 => 'mail',
          5 => 'turnover',
          6 => 'country_source',
          7 => 'country_receiver',
          8 => 'sources',
          9 => 'own_sources',
        ),
        'modify' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'contact',
          3 => 'mail',
          4 => 'turnover',
          5 => 'country_receiver',
          6 => 'country_source',
          7 => 'sources',
          8 => 'own_sources',
        ),
        'add' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'contact',
          3 => 'mail',
          4 => 'turnover',
          5 => 'country_source',
          6 => 'country_receiver',
          7 => 'sources',
          8 => 'own_sources',
        ),
        'site_form' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'bank_id',
          3 => 'currency_id',
          4 => 'turnover',
          5 => 'country_source',
          6 => 'country_receiver',
          7 => 'sources',
          8 => 'own_sources',
        ),
        'site_form_check' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'turnover',
          3 => 'country_source',
          4 => 'country_receiver',
          5 => 'sources',
          6 => 'own_sources',
        ),
        'site_mail' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'turnover',
          3 => 'country_source',
          4 => 'country_receiver',
          5 => 'sources',
          6 => 'own_sources',
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
          3 => 'mail',
          4 => 'turnover',
          5 => 'country_source',
          6 => 'country_receiver',
          7 => 'sources',
          8 => 'own_sources',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'banks' => 
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
            'title' => 'SWIFT-код',
            'trimNE' => 'Поле "Код" не должно быть пустым',
          ),
        ),
        'currencies' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'currencies',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'banks2currencies',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Валюта',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
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
    'banks2currencies' => 
    array (
      'dont_install' => 1,
      'fields' => 
      array (
        'bank_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Банк',
          ),
        ),
        'currency_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Валюта',
          ),
        ),
      ),
      'table' => 
      array (
        'UNIQUE' => 
        array (
          'bank_currency' => 
          array (
            0 => 'bank_id',
            1 => 'currency_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'accounts2country_source' => 
    array (
      'fields' => 
      array (
        'accounts_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на открытие счета',
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
          'accounts_country_source' => 
          array (
            0 => 'accounts_id',
            1 => 'country_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'accounts2country_receiver' => 
    array (
      'fields' => 
      array (
        'accounts_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на открытие счета',
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
          'accounts_country_source' => 
          array (
            0 => 'accounts_id',
            1 => 'country_id',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'accounts' => 
    array (
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
        'account_req_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Заявка на счет',
          ),
        ),
        'bank_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Банк',
          ),
        ),
        'currency_id' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Валюта',
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
          'am' => 'bank_id',
        ),
        'currency' => 
        array (
          'table' => 'currencies',
          'field' => 'title',
          'use_ref' => 'accounts2currencies',
          'am' => 'currency_id',
        ),
      ),
      'actions' => 
      array (
        'cms_account' => 
        array (
          0 => 'account_req_id',
          1 => 'bank_id',
          2 => 'currency_id',
        ),
        'cabinet' => 
        array (
          0 => 'bank',
          1 => 'currency',
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
    'account2sources' => 
    array (
      'fields' => 
      array (
        'account_req_id' => 
        array (
          'type' => 'int',
          'lenght' => 10,
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Заявка на открытие счета',
          ),
        ),
        'source_id' => 
        array (
          'type' => 'int',
          'lenght' => 10,
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Источники происхождения ДС',
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'sources' => 
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
    'account2banks' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'account_req' => 'bank_id',
        'banks' => 'id',
      ),
    ),
    'accounts2banks' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'accounts' => 'bank_id',
        'banks' => 'id',
      ),
    ),
    'accounts2currencies' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'accounts' => 'currency_id',
        'currencies' => 'id',
      ),
    ),
    'banks2currencies' => 
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
            'table' => 'banks',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'banks2currencies',
            'field' => 'bank_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'banks2currencies',
            'field' => 'currency_id',
          ),
          1 => 
          array (
            'table' => 'currencies',
            'field' => 'id',
          ),
        ),
      ),
    ),
    'accounts2country_source' => 
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
            'table' => 'account_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'accounts2country_source',
            'field' => 'accounts_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'accounts2country_source',
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
    'accounts2country_receiver' => 
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
            'table' => 'account_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'accounts2country_receiver',
            'field' => 'accounts_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'accounts2country_receiver',
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
    'account2sources' => 
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
            'table' => 'account_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'account2sources',
            'field' => 'account_req_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'account2sources',
            'field' => 'source_id',
          ),
          1 => 
          array (
            'table' => 'sources',
            'field' => 'id',
          ),
        ),
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