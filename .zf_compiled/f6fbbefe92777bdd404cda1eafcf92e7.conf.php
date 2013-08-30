<?php
$conf = array (
  'tables' => 
  array (
    'transport_req' => 
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
        'url' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'URL',
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
            'title' => 'ФИО',
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
            'title' => 'Контактный E-mail',
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
        'cargo_name' => 
        array (
          'type' => 'text',
          'am' => 
          array (
            'type' => 'text',
            'req' => 1,
            'title' => 'Наименование товара',
          ),
        ),
        'cost' => 
        array (
          'type' => 'float',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'float',
            'req' => 1,
            'title' => 'Стоимость груза',
            'attrs' => 
            array (
              'maxlength' => 9,
            ),
          ),
        ),
        'currency' => 
        array (
          'type' => 'int',
          'length' => 10,
          'default' => 0,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Валюта',
            'htmltype' => 'select',
          ),
        ),
        'services' => 
        array (
          'virtual' => 1,
          'ref_to' => 
          array (
            'virtual' => 1,
            'table' => 'additional',
            'fields' => 
            array (
              0 => 'id',
              1 => 'title',
            ),
            'use_ref' => 'transport_req2additional',
          ),
          'am' => 
          array (
            'type' => 'checkboxes',
            'title' => 'Интересующие услуги',
            'del' => ' ',
            'field_name' => 'title',
            'title_field' => 'title',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'foreign' => 
      array (
        'currency_name' => 
        array (
          'table' => 'currencies',
          'field' => 'title',
          'use_ref' => 'transport2currencies',
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Валюта',
            'htmltype' => 'select',
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
          4 => 'url',
          5 => 'contact',
          6 => 'mail',
          7 => 'cargo_name',
          8 => 'cost',
          9 => 'currency',
          10 => 'services',
        ),
        'show' => 'all',
        'modify' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'url',
          3 => 'contact',
          4 => 'mail',
          5 => 'cargo_name',
          6 => 'cost',
          7 => 'currency',
          8 => 'services',
        ),
        'add' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'url',
          3 => 'contact,mail',
          4 => 'cargo_name',
          5 => 'cost',
          6 => 'currency',
          7 => 'services',
        ),
        'site_form' => 
        array (
          0 => 'contact',
          1 => 'mail',
          2 => 'cargo_name',
          3 => 'cost',
          4 => 'currency',
          5 => 'services',
        ),
        'site_form_check' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'url',
          3 => 'contact',
          4 => 'mail',
          5 => 'cargo_name',
          6 => 'cost',
          7 => 'currency',
          8 => 'services',
        ),
        'site_mail' => 
        array (
          0 => 'req_num',
          1 => 'req_status',
          2 => 'url',
          3 => 'contact',
          4 => 'mail',
          5 => 'cargo_name',
          6 => 'cost',
          7 => 'currency',
          8 => 'services',
        ),
        'cabinet' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'cargo_name',
          3 => 'cost',
          4 => 'currency_name',
        ),
        'showorder' => 
        array (
          0 => 'id',
          1 => 'created',
          2 => 'url',
          3 => 'contact',
          4 => 'mail',
          5 => 'cargo_name',
          6 => 'cost',
          7 => 'currency_name',
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
    'additional' => 
    array (
      'dont_install' => 1,
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
        'title' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Наименование',
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
    'loadings' => 
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
        'transport_req_id' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Заявка на транспортировку',
          ),
        ),
        'loading_city' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Пункт (город) загрузки',
          ),
        ),
        'loading_index' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Индекс',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'actions' => 
      array (
        'cms_loading' => 
        array (
          0 => 'loading_city',
          1 => 'loading_index',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'deliveries' => 
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
        'transport_req_id' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Заявка на транспортировку',
          ),
        ),
        'delivery_city' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Пункт (город) доставки',
          ),
        ),
        'delivery_index' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Индекс',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'actions' => 
      array (
        'cms_delivery' => 
        array (
          0 => 'delivery_city',
          1 => 'delivery_index',
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
    'transport_req2additional' => 
    array (
      'fields' => 
      array (
        'transport_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
        ),
        'additional_id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
        ),
      ),
      'table' => 
      array (
        'UNIQUE' => 
        array (
          'transport_req_additional' => 
          array (
            0 => 'transport_id',
            1 => 'additional_id',
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
    'transport2currencies' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'transport_req' => 'currency',
        'currencies' => 'id',
      ),
    ),
    'transport2loading_country' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'transport_req' => 'loading_country',
        'countries' => 'id',
      ),
    ),
    'transport2delivery_country' => 
    array (
      'type' => 'M-1',
      'join' => 'left outer',
      'tables' => 
      array (
        'transport_req' => 'delivery_country',
        'countries' => 'id',
      ),
    ),
    'transport_req2additional' => 
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
            'table' => 'transport_req',
            'field' => 'id',
          ),
          1 => 
          array (
            'table' => 'transport_req2additional',
            'field' => 'transport_id',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'table' => 'transport_req2additional',
            'field' => 'additional_id',
          ),
          1 => 
          array (
            'table' => 'additional',
            'field' => 'id',
          ),
        ),
      ),
    ),
  ),
  'mail' => 
  array (
    'message_transport' => 
    array (
      'from' => 'no_reply@twt.ru',
      'subject' => 'Новая заявка на транспортировку № [transp_id]',
      'type' => 'text/html',
      'message' => '<p>Здравствуйте</p>
<br>Вы подали заявку на сайте [site_name]
<br>Номер заявки: [transp_id]
<br>Дата заявки: [created]
<br>Название компании: [company_name]
<br>Контактное лицо: [contact]
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
    'message_admin' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => 'Поступила заявка на перевозку № [transp_id]',
      'type' => 'text/html',
      'message' => '<p>[NO_REST]</p>
<p>Поступила заявка на перевозку № [transp_id]</p> <br />
Номер заявки: [transp_id] <br />
Дата заявки: [created] <br />
Контактное лицо: [contact] <br />
Контактный e-mail: [mail] <br />
Наименование груза: [cargo_name]
<div>Стоимость груза: [cost] [currency]</div>
<div>Дополнительные услуги: [services]</div>
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