<?php
$conf = array (
  'tables' => 
  array (
    'frames_25' => 
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
        'created' => 
        array (
          'type' => 'date',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'date',
            'req' => 1,
            'title' => 'Дата загрузки',
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
        'image' => 
        array (
          'type' => 'tinytext',
          'am' => 
          array (
            'type' => 'image',
            'title' => 'Изображение',
          ),
        ),
        'url' => 
        array (
          'type' => 'tinytext',
          'am' => 
          array (
            'type' => 'string',
            'title' => 'URL',
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
          2 => 'created',
          3 => 'text',
          4 => 'image',
          5 => 'url',
          6 => 'active',
        ),
        'add' => 
        array (
          0 => 'pos',
          1 => 'text',
          2 => 'image',
          3 => 'url',
          4 => 'active',
        ),
        'modify' => 
        array (
          0 => 'pos',
          1 => 'text',
          2 => 'image',
          3 => 'url',
          4 => 'active',
        ),
        'show' => 
        array (
          0 => 'pos',
          1 => 'created',
          2 => 'text',
          3 => 'image',
          4 => 'url',
          5 => 'active',
        ),
        'site_list' => 
        array (
          0 => 'pos',
          1 => 'text',
          2 => 'image',
          3 => 'url',
        ),
      ),
      'images' => 
      array (
        'image' => 
        array (
          'resized' => 
          array (
            'w' => 220,
            'h' => 390,
            'ratio' => 'fit',
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