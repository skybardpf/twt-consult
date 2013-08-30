<?php
$conf = array (
  'tables' => 
  array (
    'footer_menu' => 
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
            'title' => 'Родительский элемент',
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
      'foreign' => 
      array (
        'pid_ttl' => 
        array (
          'table' => 'footer_menu',
          'field' => 'title',
          'use_ref' => 'footer_menu2footer_menu',
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
          3 => 'pid_ttl',
          4 => 'url',
          5 => 'image',
          6 => 'active',
        ),
        'show' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'pid',
          3 => 'url',
          4 => 'image',
          5 => 'active',
        ),
        'modify' => 
        array (
          0 => 'title',
          1 => 'pid',
          2 => 'url',
          3 => 'image',
          4 => 'active',
        ),
        'add' => 
        array (
          0 => 'title',
          1 => 'pid',
          2 => 'url',
          3 => 'image',
          4 => 'active',
        ),
        'site_list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'pid',
          4 => 'url',
          5 => 'image',
          6 => 'active',
        ),
        'pid_list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'pid',
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
  'refs' => 
  array (
    'footer_menu2footer_menu' => 
    array (
      'type' => 'M-1',
      'self' => 
      array (
        0 => 'pid',
        1 => 'id',
      ),
      'join' => 'LEFT',
      'alias' => 'menu_title',
    ),
  ),
);
?>