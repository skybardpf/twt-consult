<?php
$conf = array (
  'tables' => 
  array (
    'services' => 
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
        'icon' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'image',
            'title' => 'Иконка',
          ),
        ),
        'pid' => 
        array (
          'type' => 'int',
          'length' => 10,
          'default' => 0,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'req' => 0,
            'null' => 'Нет родительского элемента',
            'title' => 'Категория',
            'htmltype' => 'select',
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
        'image' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'image',
            'title' => 'Изображение',
          ),
        ),
        'text' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'ckhtml',
            'htmltype' => 'ckhtml',
            'req' => 1,
            'title' => 'Текст',
          ),
        ),
        'price' => 
        array (
          'type' => 'longtext',
          'am' => 
          array (
            'type' => 'ckhtml',
            'htmltype' => 'ckhtml',
            'title' => 'Прайс',
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
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'active' => 
          array (
            0 => 'active',
          ),
        ),
      ),
      'foreign' => 
      array (
        'pid_ttl' => 
        array (
          'table' => 'services',
          'field' => 'title',
          'use_ref' => 'services2services',
          'am' => 'pid',
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'icon',
          4 => 'pid_ttl',
          5 => 'url',
          6 => 'image',
          7 => 'active',
        ),
        'show' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'icon',
          3 => 'pid',
          4 => 'url',
          5 => 'image',
          6 => 'text',
          7 => 'price',
          8 => 'active',
        ),
        'modify' => 
        array (
          0 => 'title',
          1 => 'icon',
          2 => 'pid',
          3 => 'url',
          4 => 'image',
          5 => 'text',
          6 => 'price',
          7 => 'active',
        ),
        'add' => 
        array (
          0 => 'title',
          1 => 'icon',
          2 => 'pid',
          3 => 'url',
          4 => 'image',
          5 => 'text',
          6 => 'price',
          7 => 'active',
        ),
        'site_service' => 
        array (
          0 => 'id',
          1 => 'title',
          2 => 'image',
          3 => 'text',
          4 => 'pid',
          5 => 'price',
        ),
        'site_services' => 
        array (
          0 => 'id',
          1 => 'title',
          2 => 'price',
        ),
        'site_list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'icon',
          4 => 'pid',
          5 => 'pid_ttl',
          6 => 'url',
          7 => 'image',
          8 => 'price',
        ),
      ),
      'images' => 
      array (
        'icon' => 
        array (
          'small' => 
          array (
            'w' => 50,
            'h' => 50,
            'ratio' => 'equal',
            'cut' => 5,
          ),
          'middle' => 
          array (
            'w' => 90,
            'h' => 90,
            'ratio' => 'equal',
            'cut' => 5,
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'additional' => 
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
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'active' => 
          array (
            0 => 'active',
          ),
          'pos' => 
          array (
            0 => 'pos',
          ),
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'active',
        ),
        'show' => 'all',
        'modify' => 
        array (
          0 => 'title',
          1 => 'active',
        ),
        'add' => 
        array (
          0 => 'title',
          1 => 'active',
          2 => 'pos',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
  'refs' => 
  array (
    'services2services' => 
    array (
      'type' => 'M-1',
      'self' => 
      array (
        0 => 'pid',
        1 => 'id',
      ),
      'join' => 'LEFT',
      'alias' => 'service_title',
    ),
  ),
);
?>