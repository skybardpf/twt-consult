<?php
$conf = array (
  'tables' => 
  array (
    'menu' => 
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
            'title' => 'Заголовок',
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
            'req' => 0,
            'title' => 'Изображение',
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
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'url',
          4 => 'image',
          5 => 'active',
        ),
        'show' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'url',
          3 => 'image',
          4 => 'active',
        ),
        'modify' => 
        array (
          0 => 'title',
          1 => 'url',
          2 => 'image',
          3 => 'active',
        ),
        'add' => 
        array (
          0 => 'title',
          1 => 'url',
          2 => 'image',
          3 => 'active',
        ),
        'site_list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'url',
          4 => 'image',
          5 => 'active',
        ),
      ),
      'images' => 
      array (
        'image' => 
        array (
          'middle' => 
          array (
            'w' => 50,
            'h' => 50,
            'ratio' => 'equal',
            'cut' => 5,
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
);
?>